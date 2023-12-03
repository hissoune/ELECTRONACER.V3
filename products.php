<?php
session_start();
include 'db_cnx.php';

// Check if the user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Fetch user information
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Fetch categories for the category filter
$categoryQuery = "SELECT * FROM Categories";
$categoryResult = mysqli_query($conn, $categoryQuery);
$categories = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);

// Initialize category, minPrice, and maxPrice filters
$categoryFilter = isset($_GET['categoryFilter']) ? $_GET['categoryFilter'] : '';
$minPriceFilter = isset($_GET['minPrice']) ? $_GET['minPrice'] : '';
$maxPriceFilter = isset($_GET['maxPrice']) ? $_GET['maxPrice'] : '';

// get the current page from the URL
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
// Define the number of products to display per page
$productsPerPage = 6;

// Calculate the starting product index
$startIndex = ($page - 1) * $productsPerPage;

// Fetch total number of products without limit for pagination
$totalProductsQuery = "SELECT COUNT(*) as total FROM Products";
$totalProductsResult = mysqli_query($conn, $totalProductsQuery);
$totalProductsRow = mysqli_fetch_assoc($totalProductsResult);
$numProducts = $totalProductsRow['total'];

// Calculate the total number of pages
$totalPages = ceil($numProducts / $productsPerPage);


// Fetch products with filters
$productQuery = "SELECT * FROM Products";

// Apply category filter
if ($categoryFilter != '') {
    $productQuery .= " WHERE category_id = '$categoryFilter'";
}

// Apply price filters
if ($minPriceFilter != '') {
    $productQuery .= " AND final_price >= '$minPriceFilter'";
}

if ($maxPriceFilter != '') {
    $productQuery .= " AND final_price <= '$maxPriceFilter'";
}

// Add the limit clause to the query
$productQuery .= " LIMIT $startIndex, $productsPerPage";

// Execute product query
$productResult = mysqli_query($conn, $productQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Product Listing</title>
    <style>
    .card {
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <?php include("nav.php"); ?>

    <div class="container mt-5">
        <!-- Filter form -->
        <form method="get" id="filterForm">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="categoryFilter" class="form-label">Filter by Category:</label>
                    <select name="categoryFilter" id="categoryFilter" class="form-select">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['category_id']; ?>"
                            <?php echo ($categoryFilter == $category['category_id']) ? 'selected' : ''; ?>>
                            <?php echo $category['category_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="minPrice" class="form-label">Min Price:</label>
                    <input type="text" name="minPrice" id="minPrice" class="form-control"
                        value="<?php echo $minPriceFilter; ?>">
                </div>
                <div class="col-md-4">
                    <label for="maxPrice" class="form-label">Max Price:</label>
                    <input type="text" name="maxPrice" id="maxPrice" class="form-control"
                        value="<?php echo $maxPriceFilter; ?>">
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Apply Filter</button>
                <button type="submit" class="btn btn-warning ms-2" id="lowOnStock" name="lowOnStock" value="1">Low on
                    Stock</button>
            </div>
        </form>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?php echo ($page == 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo ($page > 1) ? $page - 1 : 1; ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($page == $totalPages || $totalPages == 0) ? 'disabled' : ''; ?>">
                    <a class="page-link"
                        href="?page=<?php echo ($page < $totalPages) ? $page + 1 : $totalPages; ?>">Next</a>
                </li>
            </ul>
        </nav>
        <div class="row" id="product-container">
            <?php while ($row = mysqli_fetch_assoc($productResult)) : ?>
            <div class="col-md-4">
                <div class="card">
                    <!-- Make the image clickable and link to the product detail page -->
                    <a href="product-details.php?id=<?php echo $row['product_id']; ?>">
                        <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['label']; ?>">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['label']; ?></h5>
                        <p class="card-text">Price: $<?php echo $row['final_price']; ?></p>
                        <!-- Add to Cart button -->
                        <form method="post" action="cart.php?action=add&id=<?php echo $row['product_id']; ?>">
                            <input type="hidden" name="hidden_name" value="<?php echo $row['label']; ?>">
                            <input type="hidden" name="hidden_price" value="<?php echo $row['final_price']; ?>">
                            <input type="submit" name="add_to_cart" value="Add to Cart" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        // Submit the filter form using AJAX
        $('#filterForm').submit(function(event) {
            event.preventDefault();

            // Get the form data
            var formData = $(this).serialize();

            // Send the data using AJAX
            $.ajax({
                type: 'GET',
                url: '<?php echo $_SERVER['PHP_SELF']; ?>',
                data: formData,
                success: function(data) {
                    $('#product-container').html(data);
                }
            });
        });
    });
    </script>
    <?php include("footer.php"); ?>