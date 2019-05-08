<?php
namespace Anax\View;

/**
 * Template file to render a view for the header.
 */

$isLoggedIn = $isLoggedIn ?? false;
?>

<navbar>
    <a href="<?= url("movie/show") ?>">Visa filmer</a>
    | <a href="<?= url("movie/searchtitle") ?>">Sök titel</a>
    | <a href="<?= url("movie/searchyear") ?>">Sök år</a>
    | <a href="<?= url("movie/select") ?>">Välj film</a>
    | <a href="<?= url("movie/reset") ?>">Återställ DB</a>
</navbar>

<h1><?= $title ?></h1>
