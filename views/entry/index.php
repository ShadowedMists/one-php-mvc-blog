<?php
    include "includes/Parsedown.php";
    $settings = $this->get_settings();
    $parsedown = new Parsedown();
    $entry = $model['entry'];
    $tags = $model['tags'];
?>

<h1 class="title"><?php echo $entry->title; ?></h1>
<p class="info"><?php echo $this->get_age_string($entry->created), ' by ', $settings->display_name;?></p>
<div class="markdown">
    <?php 
        if(!empty($entry->image_url)) {
            echo '<img src="', $entry->image_url, '" alt="Title Image" />';
        }
        echo $parsedown->text($entry->body); 
    ?>
</div>
<?php if(count($tags) > 0 ) { ?>
<div>
    <span style="font-weight:bold">Tags:</span>
    <?php foreach ($tags as $tag) { ?>
    <a href="<?php echo $this->route_url(NULL, 'tag', $tag); ?>"><?php echo $tag; ?></a>
    <?php } ?>
</div>
<?php } ?>