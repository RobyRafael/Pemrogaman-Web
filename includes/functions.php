<?php
require_once __DIR__ . '/database.php';
function redirect($url) {
    header("Location: $url");
    exit();
}

function getPublishedPosts() {
    $sql = "SELECT * FROM posts WHERE status = 'published' ORDER BY created_at DESC";
    return query($sql);
}

function getPost($id) {
    $sql = "SELECT * FROM posts WHERE posts_id = ? AND status = 'published'";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getCommentsByPost($postId) {
    $sql = "SELECT * FROM comments WHERE post_id = ? AND approved = 1 ORDER BY created_at ASC";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    return $stmt->get_result();
}

function getCategory($id) {
    $sql = "SELECT * FROM categories WHERE categories_id = ?";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getPostsByCategory($categoryId) {
    $sql = "SELECT p.* FROM posts p
            JOIN post_categories pc ON p.posts_id = pc.post_id
            WHERE pc.category_id = ? AND p.status = 'published'
            ORDER BY p.created_at DESC";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    return $stmt->get_result();
}

// Fungsi tambahan untuk menambah, mengedit, dan menghapus data
function addPost($title, $content, $slug, $user_id, $status, $featured_image) {
    $sql = "INSERT INTO posts (title, content, slug, user_id, status, featured_image) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = prepare($sql);
    $stmt->bind_param("sssiss", $title, $content, $slug, $user_id, $status, $featured_image);
    return $stmt->execute();
}

function updatePost($id, $title, $content, $slug, $status, $featured_image) {
    $sql = "UPDATE posts SET title = ?, content = ?, slug = ?, status = ?, featured_image = ? WHERE posts_id = ?";
    $stmt = prepare($sql);
    $stmt->bind_param("sssssi", $title, $content, $slug, $status, $featured_image, $id);
    return $stmt->execute();
}

function deletePost($id) {
    $sql = "DELETE FROM posts WHERE posts_id = ?";
    $stmt = prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function getAllPosts() {
    $sql = "SELECT * FROM posts ORDER BY created_at DESC";
    return query($sql);
}

function getPostById($id) {
    $sql = "SELECT * FROM posts WHERE posts_id = ?";
    $stmt = prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getUserById($user_id) {
    $sql = "SELECT * FROM users WHERE users_id = ?";
    $stmt = prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getAllCategories() {
    $sql = "SELECT * FROM categories";
    return query($sql);
}

function getParentCategoryName($parent_id) {
    if ($parent_id === null) {
        return "None";
    } else {
        $sql = "SELECT name FROM categories WHERE categories_id = ?";
        $stmt = prepare($sql);
        $stmt->bind_param('i', $parent_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['name'];
    }
}

function getAllComments() {
    $sql = "SELECT * FROM comments";
    return query($sql);
}

function getAllUsers() {
    $sql = "SELECT * FROM users";
    return query($sql);
}

function getAllPublishedPosts() {
    $sql = "SELECT * FROM posts WHERE status = 'published'";
    return query($sql);
}

function getCategoryById($category_id) {
    $sql = "SELECT * FROM categories WHERE categories_id = ?";
    $stmt = prepare($sql);
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getPostsByCategoryId($category_id) {
    $sql = "SELECT * FROM posts p JOIN post_categories pc ON p.posts_id = pc.post_id WHERE pc.category_id = ?";
    $stmt = prepare($sql);
    $stmt->bind_param('i', $category_id);
    $stmt->execute();
    return $stmt->get_result();
}

function getCategories() {
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    return query($sql);
}

function getUserByEmail($email) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>
