<?php
// You can add logic here to fetch order details from the database if needed

// Redirect to the invoice page after a short delay
header("refresh:5;url=invoice.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Checkout Success</title>
</head>

<body>


    <div class="container mt-5">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Order Placed Successfully!</h4>
            <p>Thank you for your purchase. Your order has been placed successfully.</p>
            <hr>
            <p class="mb-0">You will be redirected to the invoice page shortly. If not, <a href="invoice.php">click
                    here</a>.</p>
        </div>
    </div>

    <?php
    include("footer.php")
    ?>