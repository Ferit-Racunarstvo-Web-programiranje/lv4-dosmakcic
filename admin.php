<?php
session_start();

// Provjerite je li korisnik već prijavljen
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Ako je korisnik već prijavljen, preusmjerite ga na dashboard.php
    header("Location: dashboard.php");
    exit;
}

// Provjerite je li korisnik poslao prijavni obrazac
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Pretpostavljamo da imate predefinirane podatke za administratora
    $adminEmail = 'admin@admin.com';
    $adminPassword = 'admin123';

    // Provjerite je li uneseni e-mail i lozinka ispravni
    if ($_POST['email'] === $adminEmail && $_POST['password'] === $adminPassword) {
        // Prijavite korisnika
        $_SESSION['admin_logged_in'] = true;

        // Postavite kolačić za automatsko prijavljivanje
        $cookieName = 'admin_login';
        $cookieValue = base64_encode($adminEmail);
        setcookie($cookieName, $cookieValue, time() + (86400 * 30), "/"); // Kolačić traje 30 dana

        // Preusmjerite korisnika na dashboard.php
        header("Location: dashboard.php");
        exit;
    } else {
        // Pogrešan e-mail ili lozinka, prikažite poruku o grešci
        $error = "Pogrešan e-mail ili lozinka";
    }
}

// Provjerite je li postavljen kolačić za automatsko prijavljivanje
if (isset($_COOKIE['admin_login'])) {
    // Dekodirajte kolačić i provjerite je li vrijednost ispravna
    $decodedValue = base64_decode($_COOKIE['admin_login']);
    if ($decodedValue === $adminEmail) {
        // Prijavite korisnika
        $_SESSION['admin_logged_in'] = true;

        // Preusmjerite korisnika na dashboard.php
        header("Location: dashboard.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) : ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
