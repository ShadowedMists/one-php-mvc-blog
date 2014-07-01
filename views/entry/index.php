<?php
    $settings = $this->get_settings();
    $parsedown = new Parsedown();
?>
<div class="wrap">
    <h1><?php echo $model->title; ?></h1>
    <p><?php echo $settings->display_name, ' ', $this->get_age_string($model->created);?></p>
    <div>
        <?php echo $parsedown->text($model->body); ?>
    </div>
</div>