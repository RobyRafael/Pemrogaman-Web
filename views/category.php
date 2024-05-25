<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isset($_GET['id'])) {
    die('ID not provided');
}

$category = getCategory($_GET['id']);
$posts = getPostsByCategory($category['categories_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $category['name']; ?></title>
    <link rel="stylesheet" href="/Pemrogaman-Web/public/css/styles.css">
</head>
<body>
    <?php include __DIR__ . '/../template/header.php'; ?>
    <main>
        <h1><?php echo $category['name']; ?></h1>
        <?php while ($post = fetch_assoc($posts)): ?>
            <article>
                <h2><a href="post.php?id=<?php echo $post['posts_id']; ?>"><?php echo $post['title']; ?></a></h2>
                <p><?php echo substr($post['content'], 0, 100); ?>...</p>
            </article>
        <?php endwhile; ?>
    </main>
    <?php include __DIR__ . '/../template/footer.php'; ?>
</body>
</html>
