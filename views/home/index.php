<?php $settings = $this->get_settings(); ?>
<?php foreach($model as $entry) { ?>
    <div class="entry">
        <h2><a href="<?php echo $this->route_url(NULL, 'entry', $entry->id);?>"><?php echo $entry->title; ?></a></h2>
        <p><?php echo $this->get_age_string($entry->created), ' by ', $settings->display_name; ?></p>
        <p class="snippet"><?php echo $entry->snippet; ?></>
    </div>
<?php } ?>
<div>
    <?php if (count($model) == 25) { ?>
        <a href="<?php echo $this->route_url(NULL, NULL), '/', $this->page + 1; ?>">Older Posts</a>
    <?php } if($this->page > 0) { ?>
        <a href="<?php echo $this->route_url(NULL, NULL), '/', $this->page - 1; ?>">Newer Posts</a>
    <?php }?>
</div>
