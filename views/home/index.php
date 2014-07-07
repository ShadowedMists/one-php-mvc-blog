<?php
    $settings = $this->get_settings();
    $entries = $model['entries'];
    $tags = $model['tags'];
?>
<div class="tags">
    <p style="font-weight:bold">Tags:</p>
    <?php foreach ($tags as $tag) { ?>
    <a href="<?php echo $this->route_url(NULL, 'tag', $tag); ?>"><?php echo $tag?></a>
    <?php } ?>
</div>
<?php foreach($entries as $entry) { ?>
    <div class="entry">
        <h2><a href="<?php echo $this->route_url(NULL, 'entry', $entry->id);?>"><?php echo $entry->title; ?></a></h2>
        <p><?php echo $this->get_age_string($entry->created), ' by ', $settings->display_name; ?></p>
        <p class="snippet"><?php echo $entry->snippet; ?></>
    </div>
<?php } ?>
<div>
    <?php if (count($entries) == 25) { ?>
        <a href="<?php echo $this->route_url(NULL, 'home', $this->page + 1); ?>">Older Posts</a>
    <?php } if($this->page > 0) { ?>
        <a href="<?php echo $this->route_url(NULL, 'home', $this->page - 1); ?>">Newer Posts</a>
    <?php } ?>
</div>
