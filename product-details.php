<?php
include 'db_cnx.php'; // Include your database connection file

// Check if the product ID is provided in the URL
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    // Fetch product details from the database
    $productSql = "SELECT * FROM Products WHERE product_id = $productId";
    $productResult = $conn->query($productSql);

    // Check if the product exists
    if ($productResult->num_rows > 0) {
        $product = $productResult->fetch_assoc();
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Product Details</title>

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
                <h2 class="mb-4">Product Details</h2>

                <div class="card">
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['label']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['label']; ?></h5>
                        <p class="card-text"><?php echo $product['description']; ?></p>
                        <p class="card-text"><strong>Price: $<?php echo $product['final_price']; ?></strong></p>
                        <p class="card-text">Stock Quantity: <?php echo $product['stock_quantity']; ?></p>
                        <!-- Add more details as needed -->

                        <!-- Example: Add to Cart button -->
                        <form action="add_to_cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
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
        echo "Product not found.";
    }
} else {
    echo "Product ID not provided.";
}

// Close the database connection
$conn->close();
?>