<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

checkRole('admin'); // Only admins can edit users

if (!isset($_GET['id'])) {
    die('ID not provided');
}

$user_id = $_GET['id'];
$sql = "SELECT * FROM users WHERE users_id = ?";
$stmt = prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('User not found');
}

$user = $result->fetch_assoc();

$pageTitle = "Edit User";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $name = $_POST['name'];
    $bio = $_POST['bio'];
    $avatar = $_POST['avatar'];

    $sql = "UPDATE users SET username = ?, email = ?, password = ?, role = ?, name = ?, bio = ?, avatar = ? WHERE users_id = ?";
    $stmt = prepare($sql);
    $stmt->bind_param('sssssssi', $username, $email, $password, $role, $name, $bio, $avatar, $user_id);

    if ($stmt->execute()) {
        redirect('/admin/users/list.php');
    } else {
        $message = "Error updating user.";
    }
}
?>

<?php include __DIR__ . '/../../template/header.php'; ?>

<main>
    <h1>Edit User</h1>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="edit.php?id=<?php echo $user_id; ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        
        <label for="password">Password:</
        <input type="password" id="password" name="password" placeholder="Leave blank to keep existing">
        
        <label for="role">Role:</label>
        <select id="role" name="role">
            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
            <option value="editor" <?php echo $user['role'] === 'editor' ? 'selected' : ''; ?>>Editor</option>
            <option value="author" <?php echo $user['role'] === 'author' ? 'selected' : ''; ?>>Author</option>
            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
        </select>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>">

        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio"><?php echo $user['bio']; ?></textarea>

        <label for="avatar">Avatar URL:</label>
        <input type="text" id="avatar" name="avatar" value="<?php echo $user['avatar']; ?>">

        <button type="submit">Update User</button>
    </form>
</main>

<?php include __DIR__ . '/../../template/footer.php'; ?>
