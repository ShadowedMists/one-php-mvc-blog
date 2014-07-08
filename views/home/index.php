<?php
    $settings = $this->get_settings();
    $entries = $model['entries'];
    $tags = $model['tags'];

    $prevUrl = NULL;
    $nextUrl = NULL;
    if(isset($this->tag)) {
        $prevUrl = $this->route_url(NULL, 'tag', array($this->tag, $this->page + 1));
        $nextUrl = $this->route_url(NULL, 'tag', array($this->tag, $this->page - 1));
    }
    else {
        $prevUrl = $this->route_url(NULL, 'home', $this->page + 1);
        $nextUrl = $this->route_url(NULL, 'home', $this->page - 1);
    }
?>
<div class="tags">
    <p style="font-weight:bold">Tags:</p>
    <?php foreach ($tags as $tag) { ?>
    <a href="<?php echo $this->route_url(NULL, 'tag', $tag); ?>"><?php echo $tag?></a>
    <?php } ?>
</div>
<?php foreach($entries as $entry) { ?>
    <div class="entry">
        <h2 class="title"><a href="<?php echo $this->route_url(NULL, 'entry', $entry->id);?>"><?php echo $entry->title; ?></a></h2>
        <p class="info"><?php echo $this->get_age_string($entry->created), ' by ', $settings->display_name; ?></p>
        <p class="snippet"><?php echo $entry->snippet; ?></>
    </div>
<?php } ?>
<div>
    <?php if (count($entries) == 25) { ?>
        <a href="<?php echo $prevUrl; ?>">Older Posts</a>
    <?php } if($this->page > 0) { ?>
        <a href="<?php echo $nextUrl; ?>">Newer Posts</a>
    <?php } ?>
</div>
