<?php include VIEWS_DIR . '/layout/head.php'; ?>

<div id="app">
    <div class="page">
        <h1>Tasks</h1>
        <a href="<?= route('tasks/create') ?>" class="button">New task</a>
        <div class="tasks">
            <?php foreach ($tasks as $task): ?>
                <a href="<?= route('tasks/' . $task->id) ?>" class="task <?= $task->completed ? 'completed' : '' ?>">
                    <?= $task->description ?>
                    <span class="task-created">‒ <?= date_format($task->created_at, "M d. Y H:i") ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include VIEWS_DIR . '/layout/footer.php'; ?>