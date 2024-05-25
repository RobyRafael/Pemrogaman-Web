<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

checkRole('author'); // Only authors and above can edit posts

if (!isset($_GET['id'])) {
    die('ID not provided');
}

$post_id = $_GET['id'];
$sql = "SELECT * FROM posts WHERE posts_id = ?";
$stmt = prepare($sql);
$stmt->bind_param('i', $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Post not found');
}

$post = $result->fetch_assoc();

$pageTitle = "Edit Post";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $status = $_POST['status'];
    $featured_image = $_POST['featured_image'];

    $sql = "UPDATE posts SET title = ?, content = ?, slug = ?, status = ?, featured_image = ? WHERE posts_id = ?";
    $stmt = prepare($sql);
    $stmt->bind_param('sssssi', $title, $content, $slug, $status, $featured_image, $post_id);

    if ($stmt->execute()) {
        redirect('/admin/posts/list.php');
    } else {
        $message = "Error updating post.";
    }
}
?>

<?php include __DIR__ . '/../../template/header.php'; ?>

<main>
    <h1>Edit Post</h1>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="edit.php?id=<?php echo $post_id; ?>" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $post['title']; ?>" required>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content" required><?php echo $post['content']; ?></textarea>
        
        <label for="slug">Slug:</label>
        <input type="text" id="slug" name="slug" value="<?php echo $post['slug']; ?>" required>
        
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="draft" <?php echo $post['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
            <option value="published" <?php echo $post['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
            <option value="archived" <?php echo $post['status'] === 'archived' ? 'selected' : ''; ?>>Archived</option>
        </select>

        <label for="featured_image">Featured Image URL:</label>
        <input type="text" id="featured_image" name="featured_image" value="<?php echo $post['featured_image']; ?>">

        <button type="submit">Update Post</button>
    </form>
</main>

<?php include __DIR__ . '/../../template/footer.php'; ?>
