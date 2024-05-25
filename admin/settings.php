<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

checkRole('admin'); // Only admin can access settings

$pageTitle = "Settings";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for settings
    $siteName = $_POST['site_name'];
    // You can add more settings fields as needed

    // Example query to update settings in database
    $sql = "UPDATE settings SET value = ? WHERE name = 'site_name'";
    $stmt = prepare($sql);
    $stmt->bind_param('s', $siteName);
    if ($stmt->execute()) {
        $message = "Settings updated successfully!";
    } else {
        $message = "Error updating settings.";
    }
}

// Retrieve current settings
$sql = "SELECT value FROM settings WHERE name = 'site_name'";
$result = query($sql);
$currentSettings = fetch_assoc($result);
?>

<?php include __DIR__ . '/../template/header.php'; ?>

<main>
    <h1>Settings</h1>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="settings.php" method="post">
        <label for="site_name">Site Name:</label>
        <input type="text" id="site_name" name="site_name" value="<?php echo $currentSettings['value']; ?>">
        <button type="submit">Save Settings</button>
    </form>
</main>

<?php include __DIR__ . '/../template/footer.php'; ?>
