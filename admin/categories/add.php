<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

checkRole('editor'); // Only editors and above can add categories

$pageTitle = "Add New Category";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $parent_id = $_POST['parent_id'];

    $sql = "INSERT INTO categories (name, slug, parent_id) VALUES (?, ?, ?)";
    $stmt = prepare($sql);
    $stmt->bind_param('ssi', $name, $slug, $parent_id);

    if ($stmt->execute()) {
        redirect('/admin/categories/list.php');
    } else {
        $message = "Error adding category.";
    }
}
?>

<?php include __DIR__ . '/../../template/header.php'; ?>

<main>
    <h1>Add New Category</h1>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="add.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="slug">Slug:</label>
        <input type="text" id="slug" name="slug" required>
        
        <label for="parent_id">Parent Category:</label>
        <select id="parent_id" name="parent_id">
            <option value="">None</option>
            <?php
            $categories = getAllCategories();
            while ($category = fetch_assoc($categories)):
            ?>
                <option value="<?php echo $category['categories_id']; ?>"><?php echo $category['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Add Category</button>
    </form>
</main>

<?php include __DIR__ . '/../../template/footer.php'; ?>
