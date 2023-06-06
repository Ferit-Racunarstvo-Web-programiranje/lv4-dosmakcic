<?php
include 'db.php';


if (isset($_GET['id'])) {
    $productId = $_GET['id'];

   
    $query = "SELECT * FROM products WHERE id = '$productId'";
    $result = mysqli_query($con, $query);
    $product = mysqli_fetch_assoc($result);
}


if (isset($_POST['update'])) {
   
    $newName = $_POST['name'];
    $newCode = $_POST['code'];
    $newPrice = $_POST['price'];
    $newQuantity = $_POST['quantity'];

 
    $query = "UPDATE products SET name='$newName', code='$newCode', price='$newPrice', quantity='$newQuantity' WHERE id='$productId'";
    mysqli_query($con, $query);

    header('Location: products.php');
    exit();
}


if (isset($_POST['delete'])) {
  
    $query = "DELETE FROM products WHERE id = '$productId'";
    mysqli_query($con, $query);

    
    header('Location: products.php');
    exit();
}
?>
<html>
     <head>
        <title>Update</title>
        <style>
         

body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
  margin: 0;
  padding: 20px;
}

h2 {
  margin-top: 0;
}

form {
  background-color: #ffffff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
input[type="number"] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

button {
  margin-top: 10px;
  padding: 8px 16px;
  background-color: #4caf50;
  color: #ffffff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}

a {
  color: #0066cc;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

        </style>

     </head>
        <body>
            
        </body>
</html>

<h2>Ažuriraj proizvod</h2>

<form action="update.php?id=<?php echo $productId; ?>" method="POST">
    <label for="name">Ime proizvoda:</label>
    <input type="text" name="name" value="<?php echo $product['name']; ?>" required>

    <label for="code">Kod proizvoda:</label>
    <input type="text" name="code" value="<?php echo $product['code']; ?>" required>

    <label for="price">Cijena:</label>
    <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>

    <label for="quantity">Dostupna količina:</label>
    <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required>

    <button type="submit" name="update">Ažuriraj proizvod</button>
    <button type="submit" name="delete">Obriši proizvod</button>
</form>

<a href="products.php">Povratak na popis proizvoda</a>
