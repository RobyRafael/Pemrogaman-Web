<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

// Fetch posts from the database
$posts = getAllPublishedPosts();

$pageTitle = 'Home';
?>

<?php include __DIR__ . '/../template/header.php'; ?>

<main>
    <h2>Latest Posts</h2>
    <?php if (!empty($posts)): ?>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <h3><a href="single-post.php?id=<?php echo $post['posts_id']; ?>"><?php echo $post['title']; ?></a></h3>
                    <p><?php echo substr($post['content'], 0, 150); ?>...</p>
                    <p>Published on: <?php echo $post['created_at']; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No posts available.</p>
    <?php endif; ?>
</main>

<?php include __DIR__ . '/../template/footer.php'; ?>
