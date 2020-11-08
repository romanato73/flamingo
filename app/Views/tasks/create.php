<?php include VIEWS_DIR . '/layout/head.php'; ?>

<div id="app">
    <div class="page">
        <h1>Create task</h1>
        <a href="<?= route('tasks') ?>" class="button">Back</a>
        <form action="<?= route('tasks') ?>" method="post" class="form">
            <?php form('POST') ?>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" name="description" id="description">
            </div>
            <button type="submit" class="button">Create</button>
        </form>
    </div>
</div>

<?php include VIEWS_DIR . '/layout/footer.php'; ?>