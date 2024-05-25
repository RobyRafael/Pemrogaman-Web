<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

$pageTitle = "Manage Users";
$users = getAllUsers(); // Function to get all users

?>

<?php include __DIR__ . '/../../template/header.php'; ?>

<main>
    <h1>Manage Users</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = fetch_assoc($users)): ?>
                <tr>
                    <td><?php echo $user['users_id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $user['users_id']; ?>">Edit</a> | 
                        <a href="delete.php?id=<?php echo $user['users_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include __DIR__ . '/../../template/footer.php'; ?>
