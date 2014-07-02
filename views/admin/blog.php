<table>
    <thead>
        <tr>
            <th>Title</th><th>Published</th><th>Created</th><th>Manage</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($model as $entry) { ?>
        <tr>
            <td><?php echo $entry->title; ?></td>
            <td><?php echo $entry->published == 1 ? 'Yes': 'No'; ?></td>
            <td><?php echo $this->get_age_string($entry->created); ?></td>
            <td>
                <a href="<?php echo $this->route_url('edit', 'entry', $entry->id); ?>">edit</a>
                <a href="<?php echo $this->route_url('delete', 'entry', $entry->id); ?>">delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>