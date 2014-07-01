<?php
    $error = array_key_exists('error', $model) ? $model['error'] : NULL;
    $email = array_key_exists('email', $model) ? $model['email'] : NULL;
?>
<div class="wrap">
    <div class="inner">
        <form method="post">
            <p class="error"><?php echo $error; ?></p>
            stuff
        </form>
    </div>
</div>