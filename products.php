<?php
session_start();
include 'db_cnx.php';

$query = "SELECT * FROM Products";
$result = mysqli_query($conn, $query);

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$userRole = isset($_SESSION["user"]["role"]) ? $_SESSION["user"]["role"] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Product Listing</title>
</head>


<body>
    <?php include("nav.php"); ?>
    <div class="container mt-5">
        <div class="row">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card">';
                    // Make the image clickable and link to the product detail page
                    echo '<a href="product-details.php?id=' . $row['product_id'] . '">';
                    echo '<img src="' . $row['image'] . '" class="card-img-top" alt="' . $row['label'] . '">';
                    echo '</a>';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['label'] . '</h5>';
                    echo '<p class="card-text">Price: $' . $row['final_price'] . '</p>';
                    // Add to Cart button
                    echo '<form method="post" action="cart.php?action=add&id=' . $row['product_id'] . '">';
                    echo '<input type="hidden" name="hidden_name" value="' . $row['label'] . '">';
                    echo '<input type="hidden" name="hidden_price" value="' . $row['final_price'] . '">';
                    echo '<input type="submit" name="add_to_cart" value="Add to Cart">';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No products found</p>';
            }
            ?>
        </div>

    </div>

    <?php
    include("footer.php")
    ?>