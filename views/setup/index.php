<?php 
    $redirect = isset($this->settings_redirect) ? $this->settings_redirect : NULL;
    $settings = $this->get_settings($redirect); ?>
<!DOCTYPE html>
<html lang="<?php echo $this->request->lang; ?>">
    <head>
        <title><?php echo $this->meta->title; ?></title>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <meta name="description" content="<?php echo $this->meta->description; ?>">
        <meta name="keywords" content="<?php echo $this->meta->keywords; ?>">
        <meta name="author" content="<?php echo $this->meta->author; ?>">
        <link rel="image_src" href="<?php echo $this->meta->image; ?>"/>
        <meta property="og:title" content="<?php echo $this->meta->title; ?>" />
        <meta property="og:image" content="<?php echo $this->meta->image; ?>" />
        <meta name="twitter:title" content="<?php echo $this->meta->title; ?>">
        <meta name="twitter:image" content="<?php echo $this->meta->image; ?>">
        <link href="http<?php if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') { echo 's'; }; ?>://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="/css/site.css" />
        <?php $this->render_styles(); ?>
        <?php $this->render_scripts(); ?>
    </head>
    <body>
        <div class="content">
            <h1>one-php-mvc-blog Setup</h1>
            <?php 
            $settings = $this->get_settings(FALSE);
            if($settings === NULL) {
            ?>
            <p>Congratulations! It appears the webserver is configured correctly to handle requests. We are almost done setting up and just need a few more details about your blog. Thank you for setting up one-php-mvc-blog as your blog engine.</p>
            <p class="error"><?php echo $model['error']; ?></p>
            <form method="post">
                <label for="blog_name">Blog Name</label>
                <input type="text" name="blog_name" required maxlength="63" value="<?php echo $model['blog_name']; ?>" />
                <label for="display_name">Your Name</label>
                <input type="text" name="display_name" required maxlength="63" value="<?php echo $model['display_name']; ?>" />
                <label for="email">Email</label>
                <input type="email" name="email" required maxlength="250" value="<?php echo $model['email']; ?>" />
                <label for="password">Password</label>
                <input type="password" name="password" required />
                <input type="submit" name="submit" value="Complete Setup" />
            </form>
            <?php } else { ?>
            <p>one-php-mvc-blog has already been set up. If you need to administer the site, please visit the login link below. If you need to setup the site again, you will need to delete the records in the <code>setting</code> database table to allow the setup to continue.</p>
            <?php } ?>
        </div>
        
        <footer>
            powered by <a href="https://github.com/ShadowedMists/one-php-mvc-blog" target="_blank">one-php-mvc-blog</a> | <a href="<?php echo $this->route_url(NULL, 'admin'); ?>">admin</a>
        </footer>
    </body>
</html>