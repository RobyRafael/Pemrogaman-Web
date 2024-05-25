<?php
require_once __DIR__ . '/../config/config.php';

function query($sql) {
    global $conn;
    return $conn->query($sql);
}

function fetch_assoc($result) {
    return $result->fetch_assoc();
}

function prepare($sql) {
    global $conn;
    return $conn->prepare($sql);
}
?>
