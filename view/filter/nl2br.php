<?php
namespace Anax\View;

?>
<h1>Showing off Nl2br</h1>

<h2>Nl2br source</h2>
<?= $nl2brText ?>

<h2>Text formatted as HTML source</h2>
<pre><?= htmlentities($filteredNl2brText) ?></pre>

<h2>Formatted text displayed as HTML</h2>
<?= $filteredNl2brText ?>
