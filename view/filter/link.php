<?php

namespace Anax\View;

?>
<h1>Showing off Clickable</h1>

<h2>Source in clickable.txt</h2>
<pre><?= $linkText ?></pre>

<h2>Source formatted as HTML</h2>
<?= $linkText ?>

<h2>Filter Clickable applied, source</h2>
<pre> <?= wordwrap(htmlentities($filteredLinkText), 85, "\n", true) ?> </pre>

<h2>Filter Clickable applied, HTML</h2>
<?= $filteredLinkText ?>
