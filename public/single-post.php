<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_GET['id'])) {
    die('ID not provided');
}

$post_id = $_GET['id'];
$post = getPostById($post_id);

if (!$post || $post['status'] !== 'published') {
    die('Post not found or not published');
}

$pageTitle = $post['title'];
?>

<?php include __DIR__ . '/../template/header.php'; ?>

<main>
    <article>
        <h1><?php echo $post['title']; ?></h1>
        <p><?php echo $post['content']; ?></p>
        <p>Published on: <?php echo $post['created_at']; ?></p>
        <p>By: <?php echo getUserById($post['user_id'])['username']; ?></p>
        <?php 
        // Periksa apakah kunci "category_id" ada sebelum mencoba mengaksesnya
        if (isset($post['category_id'])) {
            echo "<p>Category: " . getCategoryById($post['category_id'])['name'] . "</p>";
        } else {
            echo "<p>Category: Uncategorised</p>"; // Menangani jika kunci "category_id" tidak ada
        }
        ?>
    </article>
</main>

<?php include __DIR__ . '/../template/footer.php'; ?>
