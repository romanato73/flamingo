<?php include VIEWS_DIR . '/layout/head.php' ?>

    <div id="app">
        <div class="page">
            <h1>Editing task <small>#<?= $task->id ?></small></h1>
            <a href="<?= route('tasks') ?>" class="button">Back</a>
            <div class="page-content">
                <form action="<?= route('tasks/' . $task->id) ?>" method="post" class="form">
                    <?php form('PUT') ?>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" name="description" id="description" value="<?= $task->description; ?>">
                    </div>
                    <button type="submit" class="button">Update</button>
                </form>
            </div>
        </div>
    </div>

<?php include VIEWS_DIR . '/layout/footer.php' ?>