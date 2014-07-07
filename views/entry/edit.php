
<h1>Blog Entry</h1>
<p class="error"><?php echo $model['error']; ?></p>
<form method="post">
    <input type="hidden" name="id" value="<?php echo $model['id']; ?>" />
    <label for="title">Title</label>
    <input type="text" name="title" required maxlength="127" value="<?php echo $model['title']; ?>" />
    <label for="image_url">Entry Image URL</label>
    <input type="url" name="image_url" maxlength="255" value="<?php echo $model['image_url']; ?>" />
    <label for="published">Is Published</label>
    <input type="checkbox" name="published" <?php if($model['published'] == 1) { echo 'checked="checked"'; } ?> />
    <label for="snippet">Entry Snippet</label>
    <textarea name="snippet" required maxlength="1023" rows="5"><?php echo $model['snippet']; ?></textarea>
    <label for="body">Entry</label>
    <textarea name="body" rows="15"><?php echo $model['body']; ?></textarea>
    <label for="tags">Tags (comma seperated)</label>
    <input type="text" name="tags" value="<?php echo $model['tags']; ?>" />
    <?php if(!empty($model['id'])) { ?>
    <input type="button" value="Preview" onclick="preview()" />
    <?php } ?>
    <input type="submit" name="submit" value="Save Entry" />
</form>
<script type="text/javascript">
    function preview() {
        window.open('<?php echo $this->route_url('preview', 'entry', $model['id']); ?>', '_blank');
    }
</script>