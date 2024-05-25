<?php
// header.php

// Sertakan file functions.php
require_once(__DIR__ . '/../includes/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'CMS'; ?></title>
    <link rel="stylesheet" href="/Pemrogaman-Web/public/css/headerstyles.css">
</head>
<body>
    <header>
        <h1><a href="/Pemrogaman-Web/public">My CMS</a></h1>
        <nav>
            <ul>
                <li><a href="/index.php">Home</a></li>
                <li><a href="/categories.php">Categories</a></li>
                <li><a href="/about.php">About</a></li>
                <li><a href="/contact.php">Contact</a></li>
                <?php if (function_exists('isLoggedIn') && isLoggedIn()): ?>
                    <li><a href="/admin/dashboard.php">Dashboard</a></li>
                    <li><a href="/logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="/Pemrogaman-Web/template/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <div class="content">
