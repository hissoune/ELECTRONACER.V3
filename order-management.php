<?php
include 'db_cnx.php';
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirect to the login page if not logged in or not an admin
    header("Location: login.php");
    exit();
}

// Handle form submission for adding a new order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_order"])) {
    // Validate and sanitize the form data (you can add more validation)
    $customer_name = isset($_POST["customer_name"]) ? htmlspecialchars($_POST["customer_name"]) : '';
    $product_id = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : 0;
    $quantity = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : 0;

    // Insert the new order into the database
    $conn->query("INSERT INTO Orders (customer_name, product_id, quantity) VALUES ('$customer_name', $product_id, $quantity)");

    // Redirect to the same page to avoid resubmission on refresh
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Handle form submission for editing an order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_order"])) {
    $edited_customer_name = htmlspecialchars($_POST["edit_customer_name"]);
    $edited_product_id = intval($_POST["edit_product_id"]);
    $edited_quantity = intval($_POST["edit_quantity"]);
    $order_id_to_edit = intval($_POST["order_id_to_edit"]);

    // Update the order in the database
    $conn->query("UPDATE Orders SET customer_name = '$edited_customer_name', product_id = $edited_product_id, quantity = $edited_quantity WHERE order_id = $order_id_to_edit");

    // Redirect to the same page to avoid resubmission on refresh
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Fetch orders from the database
$orderSql = "SELECT * FROM Orders";
$orderResult = $conn->query($orderSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
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
        <h2 class="mb-4">Order List</h2>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addOrderModal">Add New
            Order</button>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Add Order Modal -->
            <div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addOrderModalLabel">Add New Order</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Your form for adding a new order goes here -->
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product ID</label>
                                <input type="number" class="form-control" id="product_id" name="product_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>

                            <button type="submit" name="add_order" class="btn btn-success">Add Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <h2 class="my-4">Edit Order</h2>

        <!-- Order List Table -->
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Order Date</th>
                    <th>Send Date</th>
                    <th>Delivery Date</th>
                    <th>Total Price</th>
                    <th>Order Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($orderData = $orderResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $orderData['order_id'] . '</td>';
                    echo '<td>' . $orderData['username'] . '</td>';
                    echo '<td>' . $orderData['order_date'] . '</td>';
                    echo '<td>' . $orderData['send_date'] . '</td>';
                    echo '<td>' . $orderData['delivery_date'] . '</td>';
                    echo '<td>' . $orderData['total_price'] . '</td>';
                    echo '<td>' . $orderData['order_status'] . '</td>';

                    echo '<td>';
                    echo '<button type="button" class="btn btn-primary btn-sm btn-modify" data-bs-toggle="modal" data-bs-target="#editOrderModal' . $orderData['order_id'] . '">Edit</button>';
                    echo '<button type="button" class="btn btn-danger btn-sm btn-modify" data-bs-toggle="modal" data-bs-target="#deleteOrderModal' . $orderData['order_id'] . '">Delete</button>';
                    echo '</td>';
                    echo '</tr>';

                    // Edit Order Modal for each order
                    echo '<!-- Edit Order Modal for Order ID ' . $orderData['order_id'] . ' -->';
                    echo '<div class="modal fade" id="editOrderModal' . $orderData['order_id'] . '" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel' . $orderData['order_id'] . '" aria-hidden="true">';
                    echo '<div class="modal-dialog">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                    echo '<h5 class="modal-title" id="editOrderModalLabel' . $orderData['order_id'] . '">Edit Order</h5>';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    // Your form for editing the order goes here
                    // Populate the form fields with existing order data
                    echo '<div class="mb-3">';
                    echo '<label for="edit_customer_name" class="form-label">Customer Name</label>';
                    echo '<input type="text" class="form-control" id="edit_customer_name" name="edit_customer_name" value="' . $orderData['customer_name'] . '" required>';
                    echo '</div>';
                    echo '<div class="mb-3">';
                    echo '<label for="edit_product_id" class="form-label">Product ID</label>';
                    echo '<input type="number" class="form-control" id="edit_product_id" name="edit_product_id" value="' . $orderData['product_id'] . '" required>';
                    echo '</div>';
                    echo '<div class="mb-3">';
                    echo '<label for="edit_quantity" class="form-label">Quantity</label>';
                    echo '<input type="number" class="form-control" id="edit_quantity" name="edit_quantity" value="' . $orderData['quantity'] . '" required>';
                    echo '</div>';
                    echo '<button type="submit" name="edit_order" class="btn btn-primary">Save Changes</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php
    include("footer.php")
    ?>

    <?php
// Helper function to get product name by ID
function getProductName($conn, $productId)
{
    $productSql = "SELECT label FROM Products WHERE product_id = $productId";
    $productResult = $conn->query($productSql);
    $productData = $productResult->fetch_assoc();

    return $productData ? $productData['label'] : '';
}
?>