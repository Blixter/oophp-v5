<?php
namespace Anax\View;

/**
 * Template file to render a view for creating a new row in the database
 */

$filters = ["bbcode","link","markdown","nl2br","escaped"];
$checkedFilters = explode(',', $content->filter);
?>

<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="contentId" value="<?= $content->id ?>"/>

    <p>
        <label>Title:<br> 
        <input type="text" name="contentTitle" required value="<?= $content->title ?>"/>
        </label>
    </p>

    <p>
        <label>Path:<br> 
        <input type="text" name="contentPath" value="<?= $content->path ?>"/>
    </p>

    <p>
        <label>Slug:<br> 
        <input type="text" name="contentSlug" value="<?= $content->slug ?>"/>
    </p>

    <p>
        <label>Text:<br> 
        <textarea name="contentData"><?= $content->data ?></textarea>
     </p>

     <p>
         <label>Type:<br> 
         <input type="radio" name="contentType" value="post" required <?php if ($content->type == "post") : ?>
                                                               checked<?php endif; ?>/> Post<br>
         <input type="radio" name="contentType" value="page" required <?php if ($content->type == "page") : ?>
                                                              checked <?php endif; ?>/> Page<br>

     </p>

     <p>
        <label>Filters:<br> 

        <?php foreach ($filters as $filter) : ?>
        <input type="checkbox" name="contentFilter[]" value="<?= $filter ?>" <?= !in_array($filter, $checkedFilters) ? "" : "checked" ?>><?= $filter ?>
        <?php endforeach; ?>
     </p>

     <p>
         <label>Publish:<br> 
         <input type="datetime" name="contentPublish" value="<?= $content->published ?>"/>
     </p>

    <p>
        <input type="submit" name="doSave" value="Save">
        <input type="submit" name="doDelete" value="Ta bort">
    </p>
    </fieldset>
</form>
