<?php
session_start();
include('db.php'); 


if (!empty($_SESSION["shopping_cart"])) {
  $cartItems = $_SESSION["shopping_cart"];
} else {
  $cartItems = array();
}


$mergedCart = array();
foreach ($_SESSION["shopping_cart"] as $item) {
  $code = $item['code'];
  if (array_key_exists($code, $mergedCart)) {
    $mergedCart[$code]['quantity'] += $item['quantity'];
  } else {
    $mergedCart[$code] = $item;
  }
}
$_SESSION["shopping_cart"] = $mergedCart;

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Cart</title>
  <link rel="stylesheet" type="text/css" href="style.css">

  <style>
  .cart-container {
   
    flex-wrap: wrap;
    align-items: flex-start;
    margin-top: 20px;
  }

  .cont{
    display: flex;
  }

  .cart-details {
    flex: 1 1 50%;
    margin-right: 20px;
  }

  .cart-form {
    background: grey;
    border-radius: 3em;
  flex: 1 1 50%;
  margin-right: 350px;
  align-self: flex-start;
  margin-top: 0;
  padding-left: 50px;
}

  .cart-form label {
    display: block;
    margin-bottom: 5px;
  }

  .cart-form input {
    width: 200px;
    margin-bottom: 10px;
  }

  .cart-form .buy-btn-cart {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 5px;
    padding: 0.5em 1em;
    font-size: 1em;
    cursor: pointer;
    margin-top: 1em;
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
  <div class="cart-container">
    <div class="cart_div">
      <?php
      if (!empty($_SESSION["shopping_cart"])) {
        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
        echo '<a href="cart.php"><img src="images/shopping-cart.png" style="width: 30px; height: 30px;" /> <span class="cart-count">' . $cart_count . '</span></a>';
      }
      ?>
    </div>
      
    <div class="cont">
    <div class="cart-details">
        <h1>Your Cart</h1>

        <?php if (!empty($cartItems)) : ?>
          <div class="cart-items">
            <?php foreach ($cartItems as $item) : ?>
              <div class="cart-item">
                <h3><?php echo $item['name']; ?></h3>
                <p>Price: $<?php echo $item['price']; ?></p>
                <p>Quantity: <?php echo $item['quantity']; ?></p>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="total-price">
            <h3>Total Price: $<?php echo calculateTotalPrice($cartItems); ?></h3>
          </div>

        <?php else : ?>
          <p>Your cart is empty.</p>
        <?php endif; ?>
      </div>

      <div class="cart-form">
        <h3>Order Details</h3>
        <form id="order-form" method="post" action="">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required>

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>

          <label for="address">Address:</label>
          <input type="text" id="address" name="address" required>

          <label for="phone">Phone:</label>
          <input type="tel" id="phone" name="phone" required>
          <button class="buy-btn-cart" id="buy-btn-cart" onclick="validateFormAndRedirect()">Buy</button>

        </form>
      </div>
      
    </div>
     
    
  </div>
</div>
<script>
    function validateFormAndRedirect() {
      const nameInput = document.getElementById('name');
      const emailInput = document.getElementById('email');
      const addressInput = document.getElementById('address');
      const phoneInput = document.getElementById('phone');

      if (nameInput.value && emailInput.value && addressInput.value && phoneInput.value) {
       
        window.location.href = 'placeorder.php';
      } else {
        alert('Please fill in all the fields before placing the order.');
      }
    }
  </script>

</body>
</html>

<?php

function calculateTotalPrice($cartItems) {
  $totalPrice = 0;
  foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
  }
  return $totalPrice;
}
?>
