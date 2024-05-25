<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

$pageTitle = "Manage Comments";
$comments = getAllComments(); // Function to get all comments

?>

<?php include __DIR__ . '/../../template/header.php'; ?>

<main>
    <h1>Manage Comments</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Content</th>
                <th>User</th>
                <th>Post</th>
                <th>Approved</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($comment = fetch_assoc($comments)): ?>
                <tr>
                    <td><?php echo $comment['comments_id']; ?></td>
                    <td><?php echo $comment['content']; ?></td>
                    <td><?php echo getUserById($comment['user_id'])['username']; ?></td>
                    <td><?php echo getPostById($comment['post_id'])['title']; ?></td>
                    <td><?php echo $comment['approved'] ? 'Yes' : 'No'; ?></td>
                    <td><?php echo $comment['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include __DIR__ . '/../../template/footer.php'; ?>
