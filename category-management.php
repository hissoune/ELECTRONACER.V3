<?php
include 'db_cnx.php';
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Redirect to the login page if not logged in or not an admin
    header("Location: login.php");
    exit();
}

// Handle form submission for adding a new category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_category"])) {
    // Validate and sanitize the form data (you can add more validation)
    $category_name = isset($_POST["category_name"]) ? htmlspecialchars($_POST["category_name"]) : '';

    // Insert the new category into the database
    $conn->query("INSERT INTO Categories (category_name) VALUES ('$category_name')");

    // Redirect to the same page to avoid resubmission on refresh
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Handle form submission for editing a category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_category"])) {
    $edited_category_name = htmlspecialchars($_POST["edit_category_name"]);
    $category_id_to_edit = intval($_POST["category_id_to_edit"]);

    // Update the category in the database
    $conn->query("UPDATE Categories SET category_name = '$edited_category_name' WHERE category_id = $category_id_to_edit");

    // Redirect to the same page to avoid resubmission on refresh
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

// Fetch categories from the database
$categorySql = "SELECT * FROM Categories";
$categoryResult = $conn->query($categorySql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management</title>
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

    .btn-hide {
        width: 80px;
    }

    .btn-modify {
        width: 80px;
    }
    </style>
</head>

<body>
    <?php include("nav.php") ?>

    <div class="container">
        <h2 class="mb-4">Category List</h2>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add New
            Category</button>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Add Category Modal -->
            <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
                aria-labelledby="addCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Your form for adding a new category goes here -->
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name"
                                    required>
                            </div>

                            <button type="submit" name="add_category" class="btn btn-success">Add Category</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <h2 class="my-4">Edit Category</h2>

        <!-- Category List Table -->
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($categoryData = $categoryResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $categoryData['category_id'] . '</td>';
                    echo '<td>' . $categoryData['category_name'] . '</td>';
                    echo '<td>';
                    echo '<button type="button" class="btn btn-primary btn-sm btn-modify" data-bs-toggle="modal" data-bs-target="#editCategoryModal' . $categoryData['category_id'] . '">Edit</button>';
                    echo '<button type="button" class="btn btn-danger btn-sm btn-modify" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal' . $categoryData['category_id'] . '">Delete</button>';
                    echo '</td>';
                    echo '</tr>';

                    // Edit Category Modal for each category
                    echo '<!-- Edit Category Modal for Category ID ' . $categoryData['category_id'] . ' -->';
                    echo '<div class="modal fade" id="editCategoryModal' . $categoryData['category_id'] . '" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel' . $categoryData['category_id'] . '" aria-hidden="true">';
                    echo '<div class="modal-dialog">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                    echo '<h5 class="modal-title" id="editCategoryModalLabel' . $categoryData['category_id'] . '">Edit Category</h5>';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    
                    // Form for editing the category
                    echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                    echo '<input type="hidden" name="category_id_to_edit" value="' . $categoryData['category_id'] . '">';

                    // Your input fields for editing the category go here
                    echo '<div class="mb-3">';
                    echo '<label for="edit_category_name" class="form-label">Category Name</label>';
                    echo '<input type="text" class="form-control" id="edit_category_name" name="edit_category_name" value="' . $categoryData['category_name'] . '" required>';
                    echo '</div>';

                    echo '<button type="submit" name="edit_category" class="btn btn-primary">Save Changes</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>