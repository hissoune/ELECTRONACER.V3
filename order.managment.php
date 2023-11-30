<?php
session_start(); // Start the session
include 'db_cnx.php'; // Include your database connection file

// Check if the cart is not empty
if (!empty($_SESSION['cart'])) {
    $cartProductIds = implode(',', array_keys($_SESSION['cart']));

    // Fetch cart products from the database
    $cartSql = "SELECT * FROM Products WHERE product_id IN ($cartProductIds)";
    $cartResult = $conn->query($cartSql);

    // Check if there are products in the cart
    if ($cartResult->num_rows > 0) {
        // Assuming you have a mechanism to store order details in the database
        // Here, we are just displaying the order details

        // Generate a unique order ID (you may have your own order ID generation logic)
        $orderId = uniqid('ORDER');

        // Insert order details into the database
        // You should have a table to store order details, and you may need to modify the query accordingly
        $insertOrderSql = "INSERT INTO Orders (order_id, user_id, total_price, order_date) VALUES ('$orderId', '123', 0, NOW())";
        $conn->query($insertOrderSql);

        // Get the order ID from the database (this is just an example, you may have your own logic)
        $getOrderSql = "SELECT * FROM Orders WHERE order_id = '$orderId'";
        $orderResult = $conn->query($getOrderSql);
        $orderDetails = $orderResult->fetch_assoc();

        // Display order confirmation details
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>

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
    }

    .order-details {
        font-weight: bold;
        font-size: 1.2rem;
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Your Brand</a>
            <!-- Add navigation links as needed -->
        </div>
    </nav>

    <div class="container">
        <h2 class="mb-4">Order Confirmation</h2>

        <div class="card">
            <div class="card-body">
                <p class="order-details">Order ID: <?php echo $orderDetails['order_id']; ?></p>
                <p class="order-details">Order Date: <?php echo $orderDetails['order_date']; ?></p>
                <!-- Display more order details as needed -->

                <h4 class="mt-4">Order Items</h4>
                <?php
                        while ($cartProduct = $cartResult->fetch_assoc()) {
                            $productId = $cartProduct['product_id'];
                            $quantity = $_SESSION['cart'][$productId];
                        ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $cartProduct['label']; ?></h5>
                        <p class="card-text">Quantity: <?php echo $quantity; ?></p>
                        <p class="card-text">Price: $<?php echo $cartProduct['final_price']; ?></p>
                        <!-- Display more product details as needed -->
                    </div>
                </div>
                <?php
                        }
                        ?>
                <p class="order-details mt-4">Total Price:
                    $<?php echo number_format($orderDetails['total_price'], 2); ?></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
    } else {
        echo "No products in the cart.";
    }
} else {
    echo "Cart is empty.";
}

// Close the database connection
$conn->close();
?>