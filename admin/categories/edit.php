<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

checkRole('editor'); // Only editors and above can edit categories

if (!isset($_GET['id'])) {
    die('ID not provided');
}

$category_id = $_GET['id'];
$sql = "SELECT * FROM categories WHERE categories_id = ?";
$stmt = prepare($sql);
$stmt->bind_param('i', $category_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Category not found');
}

$category = $result->fetch_assoc();

$pageTitle = "Edit Category";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $parent_id = $_POST['parent_id'];

    $sql = "UPDATE categories SET name = ?, slug = ?, parent_id = ? WHERE categories_id = ?";
    $stmt = prepare($sql);
    $stmt->bind_param('ssii', $name, $slug, $parent_id, $category_id);

    if ($stmt->execute()) {
        redirect('/admin/categories/list.php');
    } else {
        $message = "Error updating category.";
    }
}
?>

<?php include __DIR__ . '/../../template/header.php'; ?>

<main>
    <h1>Edit Category</h1>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form action="edit.php?id=<?php echo $category_id; ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $category['name']; ?>" required>
        
        <label for="slug">Slug:</label>
        <input type="text" id="slug" name="slug" value="<?php echo $category['slug']; ?>" required>
        
        <label for="parent_id">Parent Category:</label>
        <select id="parent_id" name="parent_id">
            <option value="">None</option>
            <?php
            $categories = getAllCategories();
            while ($cat = fetch_assoc($categories)):
            ?>
                <option value="<?php echo $cat['categories_id']; ?>" <?php echo $cat['categories_id'] === $category['parent_id'] ? 'selected' : ''; ?>><?php echo $cat['name']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Update Category</button>
    </form>
</main>

<?php include __DIR__ . '/../../template/footer.php'; ?>
