<select id="categories" name="categories[]" multiple size="5" required>
    <?php foreach ($data["categories"] as $category): ?>
        <option value="<?= htmlspecialchars($category->getId()) ?>">
            <?= htmlspecialchars($category->getName()) ?>
        </option>
    <?php endforeach; ?>
</select>