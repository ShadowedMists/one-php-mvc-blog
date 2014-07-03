<?php
    $settings = $this->get_settings();
    $parsedown = new Parsedown();
?>

<h1><?php echo $model->title; ?></h1>
<p><?php echo $this->get_age_string($model->created), ' by ', $settings->display_name;?></p>
<div class="markdown">
    <?php 
        if(!empty($model->image_url)) {
            echo '<img src="', $model->image_url, '" alt="Title Image" />';
        }
        echo $parsedown->text($model->body); 
    ?>
</div>