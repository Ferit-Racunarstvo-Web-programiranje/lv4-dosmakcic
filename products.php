<?php
include 'db.php';


if (isset($_GET['update'])) {
    $productId = $_GET['update'];

 
    $query = "SELECT * FROM products WHERE id = '$productId'";
    $result = mysqli_query($con, $query);
    $product = mysqli_fetch_assoc($result);
}


if (isset($_GET['delete'])) {
    $productId = $_GET['delete'];

    $query = "DELETE FROM products WHERE id = '$productId'";
    mysqli_query($con, $query);
    echo "Proizvod je uspješno obrisan.";
}


$query = "SELECT * FROM products";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Proizvodi</title>
    <style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

.dashboard-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

h2 {
  text-align: center;
}

nav {
  background-color: #333;
  padding: 10px;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1;
}

nav ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
  text-align: center;
}

nav ul li {
  display: inline-block;
}

nav ul li a {
  display: block;
  padding: 10px 20px;
  text-decoration: none;
  color: #fff;
}

nav ul li a:hover {
  background-color: #555;
}

.product-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  grid-gap: 20px;
  margin-top: 60px;
}

.product {
  border: 1px solid #ccc;
  padding: 20px;
  text-align: center;
}

.product img {
  width: 100%;
  max-height: 200px;
  object-fit: cover;
}

.btn-update {
  display: block;
  margin-top: 10px;
  text-decoration: none;
  background-color: #007bff;
  color: #fff;
  padding: 8px 16px;
  border-radius: 4px;
}

.add-product-btn {
  position: fixed;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  text-decoration: none;
  background-color: #007bff;
  color: #fff;
  padding: 12px 24px;
  border-radius: 4px;
}
    </style>
</head>
<body>
    <div class="dashboard-container">
        <nav>
          <ul>
            <li><a href="index.php">Početna</a></li>
            <li><a href="products.php">Proizvodi</a></li>
            <li><a href="placeorder.php">Narudžbe</a></li>
            <li><a href="?logout=true">Odjava</a></li>
          </ul>
        </nav>

        <div class="product-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='product'>";
                    echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "' />";
                    echo "<h3>" . $row['name'] . "</h3>";
                    echo "<p>Cijena: $" . $row['price'] . "</p>";
                    echo "<p>Dostupna količina: " . $row['quantity'] . "</p>";
                    echo "<a href='update.php?id=" . $row['id'] . "' class='btn-update'>Ažuriraj proizvod</a>";
                    echo "</div>";
                }
            } else {
                echo "Nema dostupnih proizvoda.";
            }
            ?>
        </div>

        <a href="product.php" class="add-product-btn">Dodaj proizvod</a>
    </div>
</body>
</html>
