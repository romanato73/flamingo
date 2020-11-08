<?php include VIEWS_DIR . '/layout/head.php' ?>

    <div id="app" class="perfect">
        <div class="app-name">
            FLAMiNGO
        </div>
        <div class="app-details">
            <p>A Simple PHP MVC Framework.</p>
            <a href="https://github.com/romanato73/flamingo/releases" class="app-link" target="_blank">News</a>
            <a href="https://github.com/romanato73/flamingo#readme" class="app-link" target="_blank">About</a>
            <a href="<?= route('tasks') ?>" class="app-link">CRUD Test</a>
        </div>
    </div>

<?php include VIEWS_DIR . '/layout/footer.php' ?>