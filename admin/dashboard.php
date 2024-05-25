<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

$pageTitle = "Dashboard";
?>

<?php include __DIR__ . '/../template/header.php'; ?>

<main>
    <h1>Admin Dashboard</h1>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    <div class="admin-links">
        <ul>
            <li><a href="posts.php">Manage Posts</a></li>
            <li><a href="categories.php">Manage Categories</a></li>
            <li><a href="comments.php">Manage Comments</a></li>
            <li><a href="users.php">Manage Users</a></li>
            <li><a href="settings.php">Settings</a></li>
        </ul>
    </div>
</main>

<?php include __DIR__ . '/../template/footer.php'; ?>
