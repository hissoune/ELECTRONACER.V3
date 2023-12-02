<?php
include('db_cnx.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Fetch user information from the database
$userId = $_SESSION['user']['user_id'];
$userSql = "SELECT * FROM Users WHERE user_id = '$userId'";
$userResult = $conn->query($userSql);

// Check if the user exists
if ($userResult->num_rows > 0) {
    $userData = $userResult->fetch_assoc();
    $fullName = $userData['full_name'];
    $address = $userData['address'];
} else {
    echo "User information not found. Please update your profile. Error: " . mysqli_error($conn);
    exit();
}

// Retrieve cart items from the session
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Calculate total price
$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['quantity'] * $item['price'];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Invoice</title>
</head>

<body>

    <?php include("nav.php"); ?>

    <div class="container mt-5">
        <h2>Invoice</h2>

        <!-- Display user information fetched from the database -->
        <div class="mb-4">
            <strong>Full Name:</strong> <?php echo $fullName; ?><br>
            <strong>Address:</strong> <?php echo $address; ?><br>
            <!-- Add more fields as needed -->
        </div>

        <!-- Display a summary of the order -->
        <h4>Order Summary:</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item) : ?>
                    <tr>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo $item['price']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Display total price -->
        <p><strong>Total Price:</strong> $<?php echo number_format($totalPrice, 2); ?></p>

    </div>
    <?php
    include("footer.php")
    ?>