<?php
session_start(); // Start the session
include 'db_cnx.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to the login page if not logged in
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
} else {
    echo "User not found.";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>

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

        .user-details {
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
        <h2 class="mb-4">User Info</h2>

        <div class="card">
            <div class="card-body">
                <p class="user-details">User ID: <?php echo $userData['user_id']; ?></p>
                <p class="user-details">Username: <?php echo $userData['username']; ?></p>
                <p class="user-details">Email: <?php echo $userData['email']; ?></p>
                <!-- Display more user details as needed -->
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>