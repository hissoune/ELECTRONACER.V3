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
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Shopping Cart</title>

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

                .total-price {
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
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Products</a>
                            </li>
                            <!-- Add more navigation links as needed -->
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container">
                <h2 class="mb-4">Shopping Cart</h2>

                <?php
                $totalPrice = 0;

                while ($cartProduct = $cartResult->fetch_assoc()) {
                    $productId = $cartProduct['product_id'];
                    $quantity = $_SESSION['cart'][$productId];
                    $subtotal = $cartProduct['final_price'] * $quantity;
                    $totalPrice += $subtotal;
                ?>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $cartProduct['label']; ?></h5>
                            <p class="card-text">Quantity: <?php echo $quantity; ?></p>
                            <p class="card-text">Price: $<?php echo $cartProduct['final_price']; ?></p>
                            <p class="card-text">Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
                            <!-- Add more details as needed -->
                        </div>
                    </div>
                <?php
                }
                ?>

                <p class="total-price">Total Price: $<?php echo number_format($totalPrice, 2); ?></p>

                <!-- Add checkout or continue shopping button as needed -->
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