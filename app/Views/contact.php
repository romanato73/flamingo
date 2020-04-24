<?php include 'partials/head.php'; ?>

<h1>Submit Your Message</h1>

<form action="<?= route('contact') ?>" method="POST">
    <div class="input">
        <label for="user">User</label>
        <input type="text" name="user" id="user">
    </div>

    <div class="input">
        <label for="message">Message</label>
        <input type="text" name="message" id="message">
    </div>

    <button type="submit" class="btn">Submit</button>
</form>

<h1>Sent Messages</h1>

<?php foreach ($messages as $message): ?>
    <div class="message">
        <p>From: <?= $message->author ?></p>
        <p>Message: <?= $message->message ?></p>
    </div>
<?php endforeach; ?>

<?php include 'partials/footer.php'; ?>