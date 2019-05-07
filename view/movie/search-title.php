<?php
namespace Anax\View;

/**
 * Template file to render a view for search-title.
 */

?>


<form method="get">
    <fieldset>
    <legend>Search</legend>
    <!-- <input type="hidden" name="route" value="searchTitle"> -->
    <p>
        <label>Title (use % as wildcard):
            </label>
            <input type="search" name="searchTitle" value="<?= htmlentities($searchTitle) ?>">
        </p>
    <p>
        <input type="submit" name="doSearch" value="Sök">
    </p>
    </fieldset>
</form>
