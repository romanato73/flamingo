<?php include 'partials/head.php'; ?>

    <main class="container">
        <div class="display-4 mb-4">Tasks</div>

        <div class="row row-cols-1 mb-4">
            <ul class="list-group">
                <?php
                if (empty($tasks)) echo 'No tasks have been found in database.';
                foreach ($tasks as $task): ?>
                    <li class="list-group-item <?= $task->completed ? "completed" : ""; ?>">
                        <?= $task->description; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <hr class="border-light">

        <form action="/tasks" method="post">
            <h3>Add a task</h3>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description">
            </div>
            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn w-25 btn-primary">Add</button>
            </div>
        </form>
    </main>

<?php include 'partials/footer.php'; ?>