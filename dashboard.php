<?php
session_start();

// Provjerite je li administrator prijavljen, inače preusmjerite na login
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: admin.php");
  exit;
}

// Odjava korisnika
if(isset($_GET['logout']) && $_GET['logout'] === 'true') {
  // Obrišite sesiju i kolačić za prijavu
  session_unset();
  session_destroy();
  setcookie('admin_login', '', time() - 3600, "/");

  // Preusmjerite na login stranicu
  header("Location: admin.php");
  exit;
}



?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>

  
<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

.dashboard-container {
  
  margin: 0 auto;
  padding: 20px;
 
}

h2 {
  text-align: center;
}

nav {
  background-color: #333;
  padding: 10px;
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

  <div class="dashboard-container">
    
    <nav>
      <ul>
        <li><a href="index.php">Početna</a></li>
        <li><a href="products.php">Proizvodi</a></li>
        <li><a href="pčaceorder.php">Narudžbe</a></li>
        <li><a href="?logout=true">Odjava</a></li>
      </ul>
    </nav>

    
    <!-- Ostatak sadržaja stranice -->
  </div>
</body>
</html>
