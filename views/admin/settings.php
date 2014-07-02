<h1>Blog Information</h1>
<p class="error"><?php echo $model['error']; ?></p>
<form method="post">
    <label for="blog_name">Blog Name</label>
    <input type="text" name="blog_name" required maxlength="63" value="<?php echo $model['blog_name']; ?>" />
    <label for="display_name">Your Name</label>
    <input type="text" name="display_name" required maxlength="63" value="<?php echo $model['display_name']; ?>" />
    <label for="email">Email</label>
    <input type="email" name="email" required maxlength="250" value="<?php echo $model['email']; ?>" />
    <input type="submit" name="submit" value="Save Blog Information" />
</form>