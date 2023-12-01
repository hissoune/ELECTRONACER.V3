<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
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

        .form-group {
            margin-bottom: 20px;
        }

        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4">Edit User</h2>
        <?php
        include 'db_cnx.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
            $userId = $_POST["user_id"];
            $newUsername = $_POST["edit_username"];
            $newEmail = $_POST["edit_email"];
            $newRole = $_POST["edit_role"];
            $newVerified = $_POST["edit_verified"];
            $newFullName = $_POST["edit_full_name"];
            $newPhoneNumber = $_POST["edit_phone_number"];
            $newAddress = $_POST["edit_address"];
            $newCity = $_POST["edit_city"];
            $newStatus = $_POST["edit_status"];

            // Update the user details in the database
            $updateSql = "UPDATE Users SET 
                username = '$newUsername',
                email = '$newEmail',
                role = '$newRole',
                verified = '$newVerified',
                full_name = '$newFullName',
                phone_number = '$newPhoneNumber',
                address = '$newAddress',
                city = '$newCity',
                hidden = '$newStatus'
                WHERE user_id = $userId";

            if ($conn->query($updateSql) === TRUE) {
                echo '<div class="alert alert-success" role="alert">';
                echo 'Record updated successfully';
                echo '</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">';
                echo 'Error updating record: ' . $conn->error;
                echo '</div>';
            }

            // Close the database connection
            $conn->close();
        }
        ?>

        <!-- Add a button to return to the user list page -->
        <a href="user_list.php" class="btn btn-primary btn-back">Back to User List</a>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>