<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

$pageTitle = "Manage Posts";
$posts = getAllPosts(); // Function to get all posts

?>

<?php include __DIR__ . '/../../template/header.php'; ?>

<main>
    <h1>Manage Posts</h1>
    <a href="add.php" class="btn">Add New Post</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($post = fetch_assoc($posts)): ?>
                <tr>
                    <td><?php echo $post['posts_id']; ?></td>
                    <td><?php echo $post['title']; ?></td>
                    <td><?php echo getUserById($post['user_id'])['username']; ?></td>
                    <td><?php echo ucfirst($post['status']); ?></td>
                    <td><?php echo $post['created_at']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $post['posts_id']; ?>">Edit</a> | 
                        <a href="delete.php?id=<?php echo $post['posts_id']; ?>" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include __DIR__ . '/../../template/footer.php'; ?>
