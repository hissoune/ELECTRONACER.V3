


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <title>Document</title>
    </head>

    <body>
    <form method="post" action="" enctype="multipart/form-data" class="container mt-5">
    <!-- Nom du produit -->
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Reference</span>
        <input type="text" class="form-control" placeholder="Nom du produit" name="label"
            aria-label="Nom du produit" aria-describedby="basic-addon1" required>
    </div>

    <!-- Description du produit -->
    <div class="input-group mb-3">
        <textarea class="form-control" placeholder="Description du produit" name="description"
            aria-label="Description du produit" required></textarea>
    </div>

    <!-- Prix du produit -->
    <div class="input-group mb-3">
        <span class="input-group-text">Purchase Price $</span>
        <input type="text" class="form-control" placeholder="Prix du produit" name="purchase_price"
            aria-label="Prix du produit" required>
        <span class="input-group-text">.99</span>
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text">Final Price $</span>
        <input type="text" class="form-control" placeholder="Prix du produit" name="final_price"
            aria-label="Prix du produit" required>
        <span class="input-group-text">.99</span>
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text">Price Offer $</span>
        <input type="text" class="form-control" placeholder="Prix du produit" name="price_offer"
            aria-label="Prix du produit" required>
        <span class="input-group-text">.99</span>
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text">Min Quantity</span>
        <input type="text" class="form-control" placeholder="Prix du produit" name="min_quantity"
            aria-label="Prix du produit" required>
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text">Stock Quantity</span>
        <input type="text" class="form-control" placeholder="Prix du produit" name="stock_quantity"
            aria-label="Prix du produit" required>
    </div>

    <!-- Image du produit -->
    <div class="mb-3 mt-3">
        <label for="product_image" class="form-label">Image du produit</label>
        <div class="input-group">
            <input type="file" class="form-control" name="image" id="product_image" required> 
        </div>
        <div class="form-text mt-2">Téléchargez une image du produit.</div>
    </div>

    <!-- Bouton pour soumettre le formulaire -->
    <div class="d-grid mt-3">
        <button type="submit" class="btn btn-primary btn-sm w-4" name="submit">Ajouter un produit</button>
    </div>
</form>

<br><br><br>

        <?php 
    
    ?>
<?php
require 'db_cnx.php';

// Fetch existing products from the 'Products' table
$sql = "SELECT * FROM Products";
// la fonction mysqli_query est utilisée pour exécuter une requête SQL SELECT sur la table "name du table" de la base de données.
$result = mysqli_query($conn, $sql); // katreje3 false ou true (bool)

echo "<table class='table table-bordered table-striped'>
    <thead class='thead-dark'>
        <tr>
            <th>ID</th>
            <th>Reference</th>
            <th>Label</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Barcode</th>
            <th>Purchase Price</th>
            <th>Min Quantity</th>
            <th>Stock Quantity</th>
            <th>Hidden</th>
            <th>Hidden Image</th>
        </tr>
    </thead>
    <tbody>";

// Loop through each product and display information in a table row
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['product_id'] . "</td>";
    echo "<td>" . $row['reference'] . "</td>";
    echo "<td>" . $row['label'] . "</td>";
    echo "<td>" . $row['description'] . "</td>";
    echo "<td>" . $row['final_price'] . "</td>";

    // Display the product image
    echo "<td><img src='./uploads/" . $row['image'] . "' width='100' height='100'></td>";

    echo "<td>" . $row['barcode'] . "</td>";
    echo "<td>" . $row['purchase_price'] . "</td>";
    echo "<td>" . $row['min_quantity'] . "</td>";
    echo "<td>" . $row['stock_quantity'] . "</td>";
    echo "<td>" . ($row['hidden'] ? 'Yes' : 'No') . "</td>";
    
    // Delete product button
    echo "<td><a class='btn btn-danger' href=''>hidden product</a></td>";
    
    echo "</tr>";
}

// Close the product table
echo "</tbody></table>";


// Check for form submission
if (isset($_POST['submit'])) {
    $label = $_POST['product_name'];
    $description = $_POST['product_description'];
    $final_price = $_POST['product_price'];

    // Upload the image to the server
    $img_name = $_FILES['product_image']['name'];
    $img_size = $_FILES['product_image']['size'];
    $tmp_name = $_FILES['product_image']['tmp_name'];
    $error = $_FILES['product_image']['error'];

    // Check if the uploaded image is valid
    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_ex_lc = strtolower($img_ex);
    $allowed_exs = array("jpg", "jpeg", "png");

    if (in_array($img_ex_lc, $allowed_exs)) {
        $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
        $img_upload_path = './uploads/' . $new_img_name;
        move_uploaded_file($tmp_name, $img_upload_path);

        // Insert a new product into the 'Products' table using prepared statements
        $stmt = $conn->prepare("INSERT INTO Products (label, description, final_price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $label, $description, $final_price, $new_img_name);
        $stmt->execute();
        $stmt->close();
    }
}

// Close the database connection
mysqli_close($conn);
?>











        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
        </script>
    </body>

    </html>