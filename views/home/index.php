<div>
    <?php foreach($model as $entry) { ?>
        <div class="entry">
            <h2><?php echo $entry->title; ?></h2>
            <p><?php echo $this->get_age_string($entry->created); ?></p>
            <div class="body">
                <?php echo $entry->snippet; ?>
            </div>
        </div>
    <?php } ?>
    <div>
        <?php if (count($model) == 25) { ?>
            <a href="<?php echo $this->route_url(NULL, NULL), '/', $page + 1; ?>">Older Posts</a>
        <?php } if($this->page > 0) { ?>
            <a href="<?php echo $this->route_url(NULL, NULL), '/', $page - 1; ?>">Newer Posts</a>
        <?php }?>
    </div>
</div>
