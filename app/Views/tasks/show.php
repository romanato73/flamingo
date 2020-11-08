<?php include VIEWS_DIR . '/layout/head.php' ?>

<div id="app">
    <div class="page">
        <?php if ($task): ?>
            <h1>Showing task: <small>#<?= $task->id ?></small></h1>
            <a href="<?= route('tasks') ?>" class="button">Back</a>
            <div class="task <?= $task->completed ? 'completed' : 'incomplete' ?>">
                <p><?= $task->description ?></p>
                <span class="task-created">‒ <?= date_format($task->created_at, "M d. Y H:i") ?></span>
                <div class="task-actions">
                    <form method="post" action="<?= route('tasks/' . $task->id) ?>" style="display:inline;">
                        <?php form('PUT'); ?>
                        <?php if ($task->completed): ?>
                            <button type="submit" class="task-action task-action-primary" name="completed" value="0">Mark as Incomplete</button>
                        <?php else: ?>
                            <button type="submit" class="task-action task-action-primary" name="completed" value="1">Mark as Completed</button>
                        <?php endif; ?>
                    </form>
                    <a href="<?= route('tasks/' . $task->id . '/edit') ?>" class="task-action task-action-warning">
                        Edit
                    </a>
                    <form method="post" action="<?= route('tasks/' . $task->id) ?>" style="display:inline;">
                        <?php form('DELETE'); ?>
                        <button type="submit" class="task-action task-action-danger">Delete</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <h1>Can not find this task in database.</h1>
            <a href="<?= route('tasks') ?>" class="button">Back</a>
        <?php endif; ?>
    </div>
</div>

<?php include VIEWS_DIR . '/layout/footer.php' ?>