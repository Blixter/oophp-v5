<?php
namespace Anax\View;

/**
 * Template file to render a view for showing all content
 */


?>

<?php
if (!$resultset) {
    return;
}
?>

<table class="content">
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Published</th>
        <th>Slug</th>
        <th>Path</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->slug ?></td>
        <td><?= $row->path ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
    </tr>
<?php endforeach; ?>
</table>
