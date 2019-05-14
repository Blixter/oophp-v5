<?php
namespace Anax\View;

/**
 * Template file to render a view for the header.
 */


?>

<navbar>
    <a href="<?= url("content") ?>">Visa allt</a>
    | <a href="<?= url("content/pages") ?>">Visa sidor</a>
    | <a href="<?= url("content/blog") ?>">Visa blogginlägg</a>
    <?php if (!$app->session->get("loggedin")) : ?>
    | <a href="<?= url("content/login") ?>">Logga in</a>
    <?php endif; ?>
    <?php if ($app->session->get("loggedin")) : ?>
    | <a href="<?= url("content/admin") ?>">Admin</a>
    | <a href="<?= url("content/create") ?>">Lägg till</a>
    | <a href="<?= url("content/reset") ?>">Återställ</a>
    | <a href="<?= url("content/logout") ?>">Logga ut</a>
    <?php endif; ?>
</navbar>

<h1><?= $title ?></h1>
