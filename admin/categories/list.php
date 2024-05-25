<?php
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';

if (!isLoggedIn()) {
    redirect('/login.php');
}

$pageTitle = "Manage Categories";
$categories = getAllCategories(); // Function to get all categories

?>

<?php include __DIR__ . '/../../template/header.php'; ?>

<main>
    <h1>Manage Categories</h1>
    <a href="add.php" class="btn">Add New Category</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Parent Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($category = fetch_assoc($categories)): ?>
                <tr>
                    <td><?php echo $category['categories_id']; ?></td>
                    <td><?php echo $category['name']; ?></td>
                    <td><?php echo $category['slug']; ?></td>
                    <td><?php echo getParentCategoryName($category['parent_id']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $category['categories_id']; ?>">Edit</a> | 
                        <a href="delete.php?id=<?php echo $category['categories_id']; ?>" onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include __DIR__ . '/../../template/footer.php'; ?>
