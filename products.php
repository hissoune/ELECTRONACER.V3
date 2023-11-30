<?php
include 'db_cnx.php'; // Include your database connection file
session_start();
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';
$_SESSION['role'] = $userRole;
echo "User Role: $userRole"; // Add this line for debugging
if ($userRole === 'admin' && isset($_GET['show_low_stock'])) {
    $filterConditions[] = "stock_quantity < 10"; // Adjust the threshold as needed
}

// Fetch product categories from the database
$categorySql = "SELECT * FROM Categories";
$categoryResult = $conn->query($categorySql);

// Fetch products based on category, price filter, and low stock filter
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : null;
$minPriceFilter = isset($_GET['min_price']) ? $_GET['min_price'] : null;
$maxPriceFilter = isset($_GET['max_price']) ? $_GET['max_price'] : null;

$filterConditions = [];
if ($categoryFilter) {
    $filterConditions[] = "category_id = $categoryFilter";
}
if ($minPriceFilter !== null) {
    $filterConditions[] = "final_price >= $minPriceFilter";
}
if ($maxPriceFilter !== null) {
    $filterConditions[] = "final_price <= $maxPriceFilter";
}

$filterCondition = '';
if (!empty($filterConditions)) {
    $filterCondition = 'WHERE ' . implode(' AND ', $filterConditions);
}

$sql = "SELECT * FROM Products $filterCondition";
$result = $conn->query($sql);

// Check if there are products
if ($result->num_rows > 0) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Custom CSS for styling -->
    <style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 50px;
    }

    .card {
        margin-bottom: 20px;
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Your Brand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Products</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if ($userRole === 'admin') : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Admin
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="#">Dashboard</a></li>
                            <li><a class="dropdown-item" href="#">Admin Option 1</a></li>
                            <li><a class="dropdown-item" href="#">Admin Option 2</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                    <?php elseif ($userRole === 'user') : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            User
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">User Info Page</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">Product Listing</h2>

        <!-- Filter Form -->
        <form action="" method="get">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="category" class="form-label">Filter by Category:</label>
                    <select name="category" id="category" class="form-select">
                        <option value="" selected>All Categories</option>
                        <?php
                            // Display categories in the dropdown
                            while ($category = $categoryResult->fetch_assoc()) {
                                echo "<option value='{$category['category_id']}'";
                                if ($categoryFilter == $category['category_id']) {
                                    echo " selected";
                                }
                                echo ">{$category['category_name']}</option>";
                            }
                            ?>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="min_price" class="form-label">Min Price:</label>
                    <input type="number" name="min_price" id="min_price" class="form-control"
                        value="<?php echo $minPriceFilter; ?>" placeholder="Min Price">
                </div>

                <div class="col-md-2">
                    <label for="max_price" class="form-label">Max Price:</label>
                    <input type="number" name="max_price" id="max_price" class="form-control"
                        value="<?php echo $maxPriceFilter; ?>" placeholder="Max Price">
                </div>

                <?php if ($userRole === 'admin') : ?>
                <div class="col-md-2 mt-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="show_low_stock" id="show_low_stock"
                            value="1" <?php echo isset($_GET['show_low_stock']) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="show_low_stock">
                            Show Low Stock
                        </label>
                    </div>
                </div>
                <?php endif; ?>

                <div class="col-md-2 mt-2">
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                </div>
            </div>
        </form>

        <div class="row">
            <?php
                // Loop through the products and display them as cards
                while ($row = $result->fetch_assoc()) {
                ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['label']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['label']; ?></h5>
                        <p class="card-text"><?php echo $row['description']; ?></p>
                        <p class="card-text"><strong>Price: $<?php echo $row['final_price']; ?></strong></p>
                        <a href="#" class="btn btn-primary">Add to Cart</a>
                    </div>
                </div>
            </div>
            <?php
                }
                ?>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
} else {
    echo "No products found.";
}

// Close the database connection
$conn->close();
?>