<?php
// Connect to your database
require 'db_cnx.php';

// Fetch categories from your database
$categorySql = "SELECT * FROM Categories";
$categoryResult = mysqli_query($conn, $categorySql);

$categories = array();
while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
    $categories[] = $categoryRow;
}

// Close database connection
mysqli_close($conn);

// Set appropriate header for JSON response
header('Content-Type: application/json');

// Output categories as JSON
echo json_encode($categories);
?>
