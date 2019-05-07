<?php
namespace Anax\View;

/**
 * Template file to render a view for the header.
 */

$isLoggedIn = $isLoggedIn ?? false;
?>

<navbar>
    <a href="show">Visa filmer</a>
    | <a href="searchtitle">Sök titel</a>
    | <a href="searchyear">Sök år</a>
    | <a href="select">Välj film</a>
    | <a href="reset">Återställ DB</a>
</navbar>

<h1><?= $title ?></h1>
