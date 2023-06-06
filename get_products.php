<?php
// Establish database connection
$con = mysqli_connect("localhost", "root", "", "moja_baza");

// Check if the connection was successful
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($con, $query);

// Create an array to store the products
$products = array();

// Check if there are any products
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $product = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'image' => $row['image']
        );

        // Add the product to the products array
        $products[] = $product;
    }
}

// Close the database connection
mysqli_close($con);

// Return the products as a JSON response
header('Content-Type: application/json');
echo json_encode($products);
?>
