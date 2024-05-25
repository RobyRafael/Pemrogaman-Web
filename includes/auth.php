<?php
// auth.php

require_once(__DIR__ . '/database.php');

function login($username, $password) {
    global $conn;
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['users_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        return true;
    }
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function logout() {
    session_start();
    session_unset();
    session_destroy();
    header('Location: /Pemrogaman-Web/public/index.php');
    exit;
}

function checkRole($required_role) {
    if ($_SESSION['role'] !== $required_role) {
        header('Location: /Pemrogaman-Web/public/index.php');
        exit();
    }
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    global $conn;
    $sql = "SELECT * FROM users WHERE users_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
?>
