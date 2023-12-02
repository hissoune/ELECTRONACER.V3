<?php
include('db_cnx.php');
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


</head>

<body>
    <?php include("nav.php"); ?>

    <div class="container mt-5">
        <h2 class="mb-4">Admin Dashboard</h2>

        <!-- Admin functionality goes here -->

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Admin Options</h4>
                <ul class="list-group">
                    <li class="list-group-item"><a href="user-management.php">User List</a></li>
                    <li class="list-group-item"><a href="product-management.php">Product List</a></li>
                    <li class="list-group-item"><a href="catrigory-management.php">Categories List</a></li>
                    <li class="list-group-item"><a href="order-management.php">Order List</a></li>
                </ul>
            </div>
        </div>
    </div>

    <?php
    include("footer.php")
    ?>