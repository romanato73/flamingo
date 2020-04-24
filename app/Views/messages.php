<?php include 'partials/head.php'; ?>

    <main class="container">
        <div class="display-4 mb-4">Messages</div>

        <div class="row row-cols-1 mb-4">
            <?php
            if (empty($messages)) echo 'No messages have been found in database.';
            foreach ($messages as $message): ?>
            <div class="card bg-primary mb-2">
                <div class="card-body">
                    <div class="card-title font-weight-bold">
                        <?= $message->author; ?>
                    </div>
                    <p><?= $message->body; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <hr class="border-light">

        <form action="<?= route('messages') ?>" method="post">
            <?php form('POST'); ?>
            <h3>Send a message</h3>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" class="form-control" id="author" name="author" placeholder="Anonymous">
            </div>
            <div class="form-group">
                <label for="body">Message</label>
                <textarea type="text" class="form-control" id="body" name="body" placeholder="Lorem ipsum..." rows="4"></textarea>
            </div>
            <div class="form-group d-flex justify-content-end">
                <button type="submit" class="btn w-25 btn-primary">Send</button>
            </div>
        </form>
    </main>

<?php include 'partials/footer.php'; ?>