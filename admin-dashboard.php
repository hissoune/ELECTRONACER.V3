<?php
session_start(); // Start the session
include 'db_cnx.php'; // Include your database connection file

// Check if the user is logged in as an admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>

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
            <h2 class="mb-4">Admin Dashboard</h2>

            <!-- Admin functionality goes here -->

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Admin Options</h4>
                    <ul>
                        <li><a href="#">Option 1</a></li>
                        <li><a href="#">Option 2</a></li>
                        <!-- Add more admin options as needed -->
                    </ul>
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
    // Redirect to the login page if the user is not logged in as an admin
    header("Location: login.php");
    exit();
}

// Close the database connection
$conn->close();
?>