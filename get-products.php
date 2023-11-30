<?php
include 'db_cnx.php';

$results_per_page = 6;

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$start_from = ($page - 1) * $results_per_page;

$sql = "SELECT * FROM Products LIMIT $start_from, $results_per_page";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='col-md-4'>";
        echo "<div class='card'>";
        // Existing card content
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No products found.";
}

$conn->close();
