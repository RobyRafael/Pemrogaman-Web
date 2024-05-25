<?php
// login.php

session_start();

require_once(__DIR__ . '/../includes/auth.php');

// Periksa apakah pengguna sudah login, jika iya, arahkan ke halaman utama
if (isset($_SESSION['user_id'])) {
    header('Location: /Pemrogaman-Web/public/index.php');
    exit();
}

// Tangani form submission untuk login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi input
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Periksa apakah username dan password cocok
    if (login($username, $password)) {
        // Login berhasil, arahkan ke halaman utama
        header('Location: /Pemrogaman-Web/public/index.php');
        exit();
    } else {
        // Login gagal, tampilkan pesan error
        $error = "Username or password is incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/Pemrogaman-Web/public/css/headerstyles.css">
</head>
<body>
    <header>
        <h1><a href="/Pemrogaman-Web/public">My CMS</a></h1>
        <nav>
            <ul>
                <li><a href="/Pemrogaman-Web/public/index.php">Home</a></li>
                <li><a href="/Pemrogaman-Web/public/categories.php">Categories</a></li>
                <li><a href="/Pemrogaman-Web/public/about.php">About</a></li>
                <li><a href="/Pemrogaman-Web/public/contact.php">Contact</a></li>
                <li><a href="/Pemrogaman-Web/template/login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <div class="content">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
    <?php include(__DIR__ . '/footer.php'); ?>
</body>
</html>
