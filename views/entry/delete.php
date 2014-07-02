<?php $entry = $model['entry']; ?>
<h1>Delete Blog Entry</h1>
<p class="error"><?php echo $model['error']; ?></p>
<form method="post">
    <p>Are you sure you want to delete the Blog Entry: <?php echo $entry->title; ?>?</p>
    <input type="submit" name="submit" value="Delete Blog Entry" />
</form>