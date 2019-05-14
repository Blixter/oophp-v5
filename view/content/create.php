<?php
namespace Anax\View;

/**
 * Template file to render a view for creating a new row in the database
 */


?>
<form method="post" action: <?= url("content/create") ?> >
    <fieldset>
    <legend>Create</legend>

    <p>
        <label>Title:<br> 
        <input type="text" name="contentTitle" default="A Title"/>
        </label>
    </p>

    <p>
        <button type="submit" name="doCreate"><i class="fa fa-plus" aria-hidden="true"></i> Create</button>
        <button type="reset"><i class="fa fa-undo" aria-hidden="true"></i> Reset</button>
    </p>
    </fieldset>
</form>
