<h1>Blog Administration</h1>
<h2>General Settings</h2>
<ul>
    <li><a href="<?php echo $this->route_url('settings'); ?>">Blog Settings</a></li>
    <li><a href="<?php echo $this->route_url('password'); ?>">Update Password</a></li>
</ul>
<h2>Blog Management</h2>
<ul>
    <li><a href="<?php echo $this->route_url('edit', 'entry'); ?>">New Blog Post</a></li>
</ul>