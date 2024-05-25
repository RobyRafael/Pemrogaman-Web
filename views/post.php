<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_GET['id'])) {
    die('ID not provided');
}

$post = getPost($_GET['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $post['title']; ?></title>
    <link rel="stylesheet" href="/Pemrogaman-Web/public/css/styles.css">
</head>
<body>
    <?php include __DIR__ . '/../template/header.php'; ?>
    <main>
        <article>
            <h1><?php echo $post['title']; ?></h1>
            <img src="<?php echo $post['featured_image']; ?>" alt="<?php echo $post['title']; ?>">
            <p><?php echo $post['content']; ?></p>
        </article>
        <section>
            <h2>Comments</h2>
            <?php
            $comments = getCommentsByPost($post['posts_id']);
            while ($comment = fetch_assoc($comments)):
            ?>
                <div>
                    <p><?php echo $comment['content']; ?></p>
                </div>
            <?php endwhile; ?>
        </section>
    </main>
    <?php include __DIR__ . '/../template/footer.php'; ?>
</body>
</html>
