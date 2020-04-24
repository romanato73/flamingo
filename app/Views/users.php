<?php include 'partials/head.php'; ?>

    <main class="container">
        <div class="display-4 mb-4">Users</div>

        <div class="row row-cols-1 mb-4">
            <ul class="list-group">
                <?php
                if (!count($users)) echo 'No users have been found in database.';
                foreach ($users as $user): ?>
                    <li class="list-group-item">
                        <?= $user->username; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>

<?php include 'partials/footer.php'; ?>