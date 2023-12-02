<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mx-auto dii">
        <h1 style="font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        font-size: 50px;
        color: #2504ff;
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 10px;
        margin-left: 10px;
        margin-right: 10px;
        text-align:center;
        " id="titels" class="">Catalogue de Produits</h1>

        <div class=" ">
            <div class="mb-5">
                <label class="font-bold italic text-black py-2 px-4" for="categorias">Filtre par prix</label>
                <form method="post" action="./product.php">
                    <select name="categorias" class="border rounded py-2 px-3">
                        <option value="op-0">Tous les prix</option>
                        <option value="op-1">100-200$</option>
                        <option value="op-2">300-400$</option>
                        <option value="op-3">Plus de 400$</option>
                    </select>
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2"
                        type="submit" name="filterCategory">Filtrer</button>
                </form>
            </div>
        </div>
        <div class="mb-5">
            <label class="font-bold italic text-black" for="categories">Filtre par catégories</label>
            <form method="post" action="./product.php?action=filterByCat">
                <select name="category" class="border rounded py-2 px-3">
                    <option value="0">Toutes les catégories</option>
                    <?php foreach ($categories as $category) { ?>
                    <option value="<?= $category['id_c'] ?>"><?= $category['name_c'] ?></option>
                    <?php } ?>
                </select>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2"
                    type="submit">Filtrer</button>
            </form>
        </div>

        <div class="flex items-center space-x-3 ml-5">
            <form method="post" action="./product.php?action=filterByOrderPrice">
                <label class="font-bold italic text-black" for="sort">Sort by:</label>
                <select class="w-48 border rounded py-2 px-3 focus:outline-none focus:border-blue-500" name="sort"
                    id="sort">
                    <option value=" ">Order By Price</option>
                    <option value="ASC">Price Ascending</option>
                    <option value="DESC">Price Descending</option>
                </select>

                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline-blue"
                    type="submit">Sort
                </button>
            </form>
        </div>
<div class="flex flex-wrap gap-3 max-h-200 items-center justify-center">
            <?php
            require 'db_cnx.php';


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='w-64 m-4 p-4 min-h-200	  bg-white rounded-lg shadow-md '>
            <img class='w-full h-64 object-cover mb-6 rounded-lg' src='./uploads/" . $row['image'] . "' alt=''>
            <h2 class='text-lg font-semibold text-gray-800 capitalize'>" . (isset($row['titre']) ? $row['titre'] : 'NOT FOUND') . "</h2>
            <p class='text-gray-600 mb-4'>" . (isset($row['description']) ? $row['description'] : 'No description') . "</p>
            <div class='flex items-center justify-between'>
                <h3 class='text-xl font-semibold text-gray-800'>" . (isset($row['prix']) ? $row['prix'] : 'no price??') . " $</h3>
                <button class='bg-indigo-600 text-white px-4 py-2 rounded-md'>Add to Cart</button>
            </div>
        </div>";
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'filterByOrderPrice') {
    $sort = $_POST['sort'];

    if ($sort == '') {
      $sql = "SELECT * FROM products ";
    } else {
      $sql = "SELECT * FROM products ORDER BY prix $sort";
    }
    
    

    $result = $conn->query($sql);

    if (!$result) {
        die("Error: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='w-64 m-4 p-4 min-h-200	  bg-white rounded-lg shadow-md '>
            <img class='w-full h-64 object-cover mb-6 rounded-lg' src='./uploads/" . $row['image'] . "' alt=''>
            <h2 class='text-lg font-semibold text-gray-800 capitalize'>" . (isset($row['titre']) ? $row['titre'] : 'NOT FOUND') . "</h2>
            <p class='text-gray-600 mb-4'>" . (isset($row['description']) ? $row['description'] : 'No description') . "</p>
            <div class='flex items-center justify-between'>
                <h3 class='text-xl font-semibold text-gray-800'>" . (isset($row['prix']) ? $row['prix'] : 'no price??') . " $</h3>
                <button class='bg-indigo-600 text-white px-4 py-2 rounded-md'>Add to Cart</button>
            </div>
        </div>";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' || ($_SERVER['REQUEST_METHOD'] == 'POST' && $priceRange!='')) {
    $sql = "SELECT * FROM product WHERE prix $priceRange";

    $result = $conn->query($sql);

    if (!$result) {
        die("Error: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='w-64 m-4 p-4 min-h-200	  bg-white rounded-lg shadow-md '>
            <img class='w-full h-64 object-cover mb-6 rounded-lg' src='./uploads/" . $row['image'] . "' alt=''>
            <h2 class='text-lg font-semibold text-gray-800 capitalize'>" . (isset($row['titre']) ? $row['titre'] : 'NOT FOUND') . "</h2>
            <p class='text-gray-600 mb-4'>" . (isset($row['description']) ? $row['description'] : 'No description') . "</p>
            <div class='flex items-center justify-between'>
                <h3 class='text-xl font-semibold text-gray-800'>" . (isset($row['prix']) ? $row['prix'] : 'no price??') . " $</h3>
                <button class='bg-indigo-600 text-white px-4 py-2 rounded-md'>Add to Cart</button>
            </div>
        </div>";
        }
    }
}

$conn->close();
?>
        </div>
    
</body>
</html>