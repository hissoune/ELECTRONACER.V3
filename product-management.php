<?php
include 'db_cnx.php';
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirect to the login page if not logged in or not an admin
    header("Location: login.php");
    exit();
}

// Handle form submission for adding new product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_product"])) {
    // Validate and sanitize the form data (you can add more validation)
    $reference = isset($_POST["reference"]) ? htmlspecialchars($_POST["reference"]) : '';
    $label = isset($_POST["label"]) ? htmlspecialchars($_POST["label"]) : '';
    // Add missing fields and update the SQL query
    $purchase_price = isset($_POST["purchase_price"]) ? floatval($_POST["purchase_price"]) : 0;
    $final_price = isset($_POST["final_price"]) ? floatval($_POST["final_price"]) : 0;
    $description = isset($_POST["description"]) ? htmlspecialchars($_POST["description"]) : '';
    $min_quantity = isset($_POST["min_quantity"]) ? intval($_POST["min_quantity"]) : 0;
    $stock_quantity = isset($_POST["stock_quantity"]) ? intval($_POST["stock_quantity"]) : 0;
    $category_id = isset($_POST["category_id"]) ? intval($_POST["category_id"]) : 0;

    // Insert the new product into the database
    $conn->query("INSERT INTO Products (reference, label, purchase_price, final_price, description, min_quantity, stock_quantity, category_id)
                  VALUES ('$reference', '$label', $purchase_price, $final_price, '$description', $min_quantity, $stock_quantity, $category_id)");

    // Redirect to the same page to avoid resubmission on refresh
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Handle form submission for editing a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_product"])) {
    $edited_reference = htmlspecialchars($_POST["edit_reference"]);
    // Retrieve other edited fields from the form and update the database
    // Add missing fields and update the SQL query
    $edited_purchase_price = isset($_POST["edit_purchase_price"]) ? floatval($_POST["edit_purchase_price"]) : 0;
    $edited_final_price = isset($_POST["edit_final_price"]) ? floatval($_POST["edit_final_price"]) : 0;
    $edited_description = isset($_POST["edit_description"]) ? htmlspecialchars($_POST["edit_description"]) : '';
    $edited_min_quantity = isset($_POST["edit_min_quantity"]) ? intval($_POST["edit_min_quantity"]) : 0;
    $edited_stock_quantity = isset($_POST["edit_stock_quantity"]) ? intval($_POST["edit_stock_quantity"]) : 0;

    $product_id_to_edit = intval($_POST["product_id_to_edit"]);

    // Update the product in the database
    $conn->query("UPDATE Products SET reference = '$edited_reference', 
                  purchase_price = $edited_purchase_price, 
                  final_price = $edited_final_price, 
                  description = '$edited_description', 
                  min_quantity = $edited_min_quantity, 
                  stock_quantity = $edited_stock_quantity 
                  WHERE product_id = $product_id_to_edit");

    // Redirect to the same page to avoid resubmission on refresh
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Fetch products from the database
$productSql = "SELECT * FROM Products";
$productResult = $conn->query($productSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
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

    .btn-hide {
        width: 80px;
    }

    .btn-modify {
        width: 80px;
    }
    </style>
</head>

<body>
    <?php include("nav.php") ?>

    <div class="container">
        <h2 class="mb-4">Product List</h2>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">Add New
            Product</button>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Add Product Modal -->
            <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog"
                aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Your form for adding a new product goes here -->
                            <div class="mb-3">
                                <label for="reference" class="form-label">Reference</label>
                                <input type="text" class="form-control" id="reference" name="reference" required>
                            </div>
                            <div class="mb-3">
                                <label for="label" class="form-label">Label</label>
                                <input type="text" class="form-control" id="label" name="label" required>
                            </div>
                            <!-- Add other input fields for the product details -->
                            <div class="mb-3">
                                <label for="purchase_price" class="form-label">Purchase Price</label>
                                <input type="number" class="form-control" id="purchase_price" name="purchase_price"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="final_price" class="form-label">Final Price</label>
                                <input type="number" class="form-control" id="final_price" name="final_price" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="min_quantity" class="form-label">Min Quantity</label>
                                <input type="number" class="form-control" id="min_quantity" name="min_quantity"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category ID</label>
                                <input type="number" class="form-control" id="category_id" name="category_id" required>
                            </div>

                            <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <h2 class="my-4">Edit Product</h2>

        <!-- Product List Table -->
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Reference</th>
                    <th>Label</th>
                    <th>Purchase Price</th>
                    <th>Final Price</th>
                    <th>Description</th>
                    <th>Min Quantity</th>
                    <th>Stock Quantity</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($productData = $productResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $productData['product_id'] . '</td>';
                    echo '<td>' . $productData['reference'] . '</td>';
                    echo '<td>' . $productData['label'] . '</td>';
                    echo '<td>' . $productData['purchase_price'] . '</td>';
                    echo '<td>' . $productData['final_price'] . '</td>';
                    echo '<td>' . $productData['description'] . '</td>';
                    echo '<td>' . $productData['min_quantity'] . '</td>';
                    echo '<td>' . $productData['stock_quantity'] . '</td>';
                    echo '<td>' . getCategoryName($conn, $productData['category_id']) . '</td>';
                    echo '<td>';
                    echo '<button type="button" class="btn btn-primary btn-sm btn-modify" data-bs-toggle="modal" data-bs-target="#editProductModal' . $productData['product_id'] . '">Edit</button>';
                    echo '<button type="button" class="btn btn-danger btn-sm btn-modify" data-bs-toggle="modal" data-bs-target="#deleteProductModal' . $productData['product_id'] . '">Hide</button>';
                    echo '</td>';
                    echo '</tr>';
                    // edit menu      
                    // Table data for each product

                    echo '<!-- Edit Product Modal for Product ID ' . $productData['product_id'] . ' -->';
                    echo '<div class="modal fade" id="editProductModal' . $productData['product_id'] . '" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel' . $productData['product_id'] . '" aria-hidden="true">';
                    echo '<div class="modal-dialog">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                    echo '<h5 class="modal-title" id="editProductModalLabel' . $productData['product_id'] . '">Edit Product</h5>';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    // Your form for editing the product goes here
                    echo '<div class="mb-3">';
                    echo '<label for="edit_reference" class="form-label">Reference</label>';
                    echo '<input type="text" class="form-control" id="edit_reference" name="edit_reference" value="' . $productData['reference'] . '" required>';
                    echo '</div>';
                    // Add other input fields for editing the product details
                    // ...
                    echo '<button type="submit" name="edit_product" class="btn btn-primary">Save Changes</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </tbody>
        </table>


    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Helper function to get category name by ID
function getCategoryName($conn, $categoryId)
{
    // Check if $categoryId is not NULL
    if ($categoryId !== null) {
        $categorySql = "SELECT category_name FROM Categories WHERE category_id = $categoryId";
        $categoryResult = $conn->query($categorySql);

        // Check if the query was successful
        if ($categoryResult) {
            $categoryData = $categoryResult->fetch_assoc();

            // Check if categoryData is not NULL
            if ($categoryData) {
                return $categoryData['category_name'];
            } else {
                return ''; // Return an empty string if categoryData is NULL
            }
        } else {
            // Handle query failure (you might want to log or handle this differently)
            return ''; // Return an empty string if the query fails
        }
    } else {
        return ''; // Return an empty string if $categoryId is NULL
    }
}
?>