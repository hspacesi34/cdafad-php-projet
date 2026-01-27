<container class="container">
    <h1>Liste catégories</h1>
        <label for="categories">
            Catégories
            <select id="categories" name="categories[]" multiple size="5" required>
                <?php foreach ($data["categories"] as $category): ?>
                    <option value="<?= htmlspecialchars($category['id']) ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
</container>