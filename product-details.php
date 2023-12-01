<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Product Details</title>
</head>

<body>

    <div class="container mt-5">
        <?php
        session_start(); // Start the session
        include 'db_cnx.php'; // Include your database connection file

        // Get product ID from the URL
        $product_id = isset($_GET['id']) ? $_GET['id'] : '';

        // Check if the product ID is not empty
        if (!empty($product_id)) {
            // Use prepared statement to prevent SQL injection
            $sql = "SELECT * FROM Products WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if the product exists
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        ?>
        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['label']; ?>" class="card-img">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['label']; ?></h5>
                        <p class="card-text"><strong>Reference:</strong> <?php echo $row['reference']; ?></p>
                        <p class="card-text"><strong>Description:</strong> <?php echo $row['description']; ?></p>
                        <p class="card-text"><strong>Price:</strong> $<?php echo $row['final_price']; ?></p>
                        <p class="card-text"><strong>Stock Quantity:</strong> <?php echo $row['stock_quantity']; ?></p>
                        <!-- Add to Cart button -->
                        <form method="post" action="cart.php?action=add&id=<?php echo $row['product_id']; ?>">
                            <input type="hidden" name="hidden_name" value="<?php echo $row['label']; ?>">
                            <input type="hidden" name="hidden_price" value="<?php echo $row['final_price']; ?>">
                            <input type="submit" name="add_to_cart" value="Add to Cart" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
            } else {
                echo "<p class='alert alert-danger'>Product not found</p>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<p class='alert alert-danger'>Product ID not specified</p>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>