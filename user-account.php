<?php
session_start(); // Start the session
include 'db_cnx.php'; // Include your database connection file

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Fetch user information from the database
    $userSql = "SELECT * FROM Users WHERE user_id = '$userId'";
    $userResult = $conn->query($userSql);

    // Check if the user exists
    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>

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
        <h2 class="mb-4">User Account</h2>

        <div class="card">
            <div class="card-body">
                <p class="user-details">User ID: <?php echo $userData['user_id']; ?></p>
                <p class="user-details">Username: <?php echo $userData['username']; ?></p>
                <p class="user-details">Email: <?php echo $userData['email']; ?></p>
                <!-- Display more user details as needed -->

                <h4 class="mt-4">Change Password</h4>
                <form action="change_password.php" method="post">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
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
        echo "User not found.";
    }
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Close the database connection
$conn->close();
?>