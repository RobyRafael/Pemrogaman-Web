<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

checkRole('author'); // Only authors and above can add posts

$pageTitle = "Add New Post";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $status = $_POST['status'];
    $user_id = $_SESSION['user_id'];
    $featured_image = $_POST['featured_image'];

    $sql = "INSERT INTO posts (title, content, slug, user_id, status, featured_image) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = prepare($sql);
    $stmt->bind_param('sssiss', $title, $content, $slug, $user_id, $status, $featured_image);

    if ($stmt->execute()) {
        redirect('/admin/posts/list.php');
    } else {
        $message = "Error adding post.";
    }
}
?>

<?php include __DIR__ . '/../../template/header.php'; ?>

<main>
    <h1>Add New Post</h1>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="add.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
        
        <label for="slug">Slug:</label>
        <input type="text" id="slug" name="slug" required>
        
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
            <option value="archived">Archived</option>
        </select>

        <label for="featured_image">Featured Image URL:</label>
        <input type="text" id="featured_image" name="featured_image">

        <button type="submit">Add Post</button>
    </form>
</main>

<?php include __DIR__ . '/../../template/footer.php'; ?>
