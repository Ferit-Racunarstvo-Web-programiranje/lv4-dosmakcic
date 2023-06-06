<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $code = $_POST['code'];
    $price = $_POST['price'];

    // Provjera postojanja slike i premještanje na odredište
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['tmp_name'];

        // Kreiraj putanju za spremanje slike
        $targetPath = 'images/' . basename($_FILES['image']['name']);

        // Premjesti sliku na odredišnu lokaciju
        if (move_uploaded_file($image, $targetPath)) {
            // Slika uspješno premještena, nastavi s unosom u bazu
            $query = "INSERT INTO products (name, code, price, image) VALUES ('$name', '$code', '$price', '$targetPath')";
            mysqli_query($con, $query);
            echo "Proizvod je uspješno dodan.";
        } else {
            echo "Greška pri premještanju slike.";
        }
    } else {
        echo "Greška pri unosu slike.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dodaj novi proizvod</title>
    <style>

h2{
text-align: center;
}
form {
    max-width: 400px;
    margin: 0 auto;
}

label {
    display: block;
    margin-bottom: 10px;
}

input[type="text"],
input[type="number"],
input[type="file"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

a{
    
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
a:hover{
    background-color: #45a049;
}

form{
    background: #ccc;
    padding-left: 100px;
    padding-right: 100px;
    padding-top: 50px;
    padding-bottom: 50px;
    border-radius: 5em;
}
</style>

</head>

<body>
    <h2>Dodaj novi proizvod</h2>

    <form action="product.php" method="POST" enctype="multipart/form-data">
        <label for="name">Ime proizvoda:</label>
        <input type="text" name="name" required>

        <label for="code">Kod proizvoda:</label>
        <input type="text" name="code" required>

        <label for="price">Cijena:</label>
        <input type="number" name="price" step="0.01" required>

        <label for="image">Slika:</label>
        <input type="file" name="image" required>

        <button type="submit" name="submit">Potvrdi proizvod</button>
    </form>

    <a href="products.php">Povratak na popis proizvoda</a>

</body>

</html>


