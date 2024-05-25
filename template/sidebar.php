<aside>
    <h2>Categories</h2>
    <ul>
        <?php
        $categories = getCategories();
        while ($category = fetch_assoc($categories)):
        ?>
            <li><a href="category.php?id=<?php echo $category['categories_id']; ?>"><?php echo $category['name']; ?></a></li>
        <?php endwhile; ?>
    </ul>
</aside>
