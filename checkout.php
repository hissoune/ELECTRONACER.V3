<?php
include('db_cnx.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
// Get user role from the session
$userRole = $_SESSION['user']['role'];

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
    // Handle the case where user information is not found
    echo "User information not found. Please update your profile. Error: " . mysqli_error($conn); // Debugging line
    exit();
}

// Retrieve cart items from the session
$cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Checkout</title>
</head>

<body>

    <?php include("nav.php"); ?>

    <div class="container mt-5">
        <h2>Checkout</h2>
        <form method="post" action="process-checkout.php">
            <!-- Display user information fetched from the database -->
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $fullName; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" readonly>
            </div>
            <!-- Add more fields as needed -->

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
                    <?php
                    $totalPrice = 0; // Initialize total price
                    foreach ($cartItems as $item) :
                        $totalPrice += $item['quantity'] * $item['price']; // Add the product total to the overall total
                    ?>
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

            <!-- Add a button to confirm the purchase -->
            <button type="submit" class="btn btn-primary">Confirm Purchase</button>

        </form>
    </div>

    <?php
    include("footer.php")
    ?>