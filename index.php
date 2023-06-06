<?php
session_start();
include('db.php'); //povezivanje s bazom
$status = "";

// Check if the "Remove" button is clicked
if (isset($_POST['remove_item_key']) && !empty($_SESSION['shopping_cart'])) {
  $removeKey = $_POST['remove_item_key'];

  // Remove the item from the shopping cart session
  unset($_SESSION['shopping_cart'][$removeKey]);

  // Show a success message or perform any other action
  $status = "<div class='box'>Product removed from your cart!</div>";
}

if (isset($_POST['code']) && $_POST['code'] != "") {
  $code = $_POST['code'];
  $result = mysqli_query(
    $con,
    "SELECT * FROM `products` WHERE `code`='$code'"
  );
  $row = mysqli_fetch_assoc($result);
  $name = $row['name'];
  $code = $row['code'];
  $price = $row['price'];
  $image = $row['image'];

  $cartArray = array(
    $code => array(
      'name' => $name,
      'code' => $code,
      'price' => $price,
      'quantity' => 1,
      'image' => $image
    )
  );

  if (empty($_SESSION["shopping_cart"])) {
    $_SESSION["shopping_cart"] = $cartArray;
    $status = "<div class='box'>Product is added to your cart!</div>";
  } else {
    $array_keys = array_keys($_SESSION["shopping_cart"]);
    if (in_array($code, $array_keys)) {
      $status = "<div class='box' style='color:red;'>Product is already added to your cart!</div>";
    } else {
      $_SESSION["shopping_cart"] = array_merge(
        $_SESSION["shopping_cart"],
        $cartArray
      );
      $status = "<div class='box'>Product is added to your cart!</div>";
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Web Shop</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    nav {
    background-color: #333;
    padding: 10px;
    position: relative;
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
  </style>
</head>
<body>
       <nav>
    
          <ul>
          <div class="cart-container">
           <?php
            if (!empty($_SESSION["shopping_cart"])) {
              $cart_count = count(array_keys($_SESSION["shopping_cart"]));
              ?>
              <button class="cart-button">Cart <span><?php echo $cart_count; ?></span></button>
            <?php
            }
            ?>
          </div>
            <li><a href="index.php">Početna</a></li>
            <li><a href="products.php">Proizvodi</a></li>
            <li><a href="placeorder.php">Narudžbe</a></li>
            <li><a href="?logout=true">Odjava</a></li>
          </ul>
        </nav>

 

  <div class="items-grid">
    <?php
    $query = "SELECT * FROM products";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="item">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        echo '<h2>' . $row['name'] . '</h2>';
        echo '<p>Cijena : $' . $row['price'] . '</p>';
        echo '<form method="post" class="add-to-cart-form">';
        echo '<input type="hidden" name="code" value="' . $row['code'] . '">';
        echo '<button type="submit" class="add-to-cart-btn">Add to cart</button>';
        echo '</form>';
        echo '</div>';
      }
    }
    ?>
  </div>

  <div class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Cart</h2>
      <ul class="cart-items">
        <?php
        // Check if cart items exist in session
        if (!empty($_SESSION['shopping_cart'])) {
          $total = 0; // Initialize total variable

          foreach ($_SESSION['shopping_cart'] as $item_key => $item) {
            echo '<li class="cart-item">';
            echo '<span class="item-name">' . $item['name'] . '</span>';
            echo '<span class="item-price">' . $item['price'] . '</span>';
            echo '<span class="item-quantity">' . $item['quantity'] . '</span>';
            echo '<form method="post" class="remove-form">';
            echo '<input type="hidden" name="remove_item_key" value="' . $item_key . '">';
            echo '<button type="submit" class="remove-btn">Remove</button>';
            echo '</form>';
            echo '</li>';

            // Calculate the subtotal for each item and add it to the total
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
          }
        } else {
          echo '<li class="cart-item">Your cart is empty.</li>';
        }
        ?>
      </ul>
      <p>Total: <span class="cart-total">$<?php echo number_format($total, 2); ?></span></p>
      <button class="buy-btn" onclick="location.href='cart.php'">Buy</button>
    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
