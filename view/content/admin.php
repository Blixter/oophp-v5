<?php
namespace Anax\View;

/**
 * Template file to render a the admin view.
 */

if (!$resultset) {
    return;
}
?>

<table class="content">
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Actions</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td>
            <a class="icons" href=<?= url("content/edit?id=") . $row->id ?> title="Edit this content">
                <i class="fas fa-edit" aria-hidden="true"></i>
            </a>
            <a class="icons" href=<?= url("content/delete?id=") . $row->id ?> title="Edit this content">
                <i class="fas fa-trash" aria-hidden="true"></i>
            </a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
