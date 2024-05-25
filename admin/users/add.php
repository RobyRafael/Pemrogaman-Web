<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

checkRole('admin'); // Only admins can add users

$pageTitle = "Add New User";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $name = $_POST['name'];
    $bio = $_POST['bio'];
    $avatar = $_POST['avatar'];

    $sql = "INSERT INTO users (username, email, password, role, name, bio, avatar) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = prepare($sql);
    $stmt->bind_param('sssssss', $username, $email, $password, $role, $name, $bio, $avatar);

    if ($stmt->execute()) {
        redirect('/admin/users/list.php');
    } else {
        $message = "Error adding user.";
    }
}
?>

<?php include __DIR__ . '/../../template/header.php'; ?>

<main>
    <h1>Add New User</h1>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="add.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="admin">Admin</option>
            <option value="editor">Editor</option>
            <option value="author">Author</option>
            <option value="user">User</option>
        </select>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name">

        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio"></textarea>

        <label for="avatar">Avatar URL:</label>
        <input type="text" id="avatar" name="avatar">

        <button type="submit">Add User</button>
    </form>
</main>

<?php include __DIR__ . '/../../template/footer.php'; ?>
