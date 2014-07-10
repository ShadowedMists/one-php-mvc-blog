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
<table class="manage">
    <thead>
        <tr>
            <th class="left">Title</th><th>Published</th><th>Created</th><th>Manage</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($model as $entry) { ?>
        <tr>
            <td><?php echo $entry->title; ?></td>
            <td class="center"><?php echo $entry->published == 1 ? 'Yes': 'No'; ?></td>
            <td class="center"><?php echo $this->get_age_string($entry->created); ?></td>
            <td class="center">
                <a href="<?php echo $this->route_url('edit', 'entry', $entry->id); ?>">edit</a>
                <a href="<?php echo $this->route_url('delete', 'entry', $entry->id); ?>">delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>