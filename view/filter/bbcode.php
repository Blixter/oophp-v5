<?php

namespace Anax\View;

?>

<h1>Showing off BBCode</h1>

<h2>Source in bbcode.txt</h2>
<pre><?= htmlentities($bbcodeText) ?></pre>

<h2>Filter BBCode applied, source</h2>
<pre> <?= htmlentities($filteredBbcodeText) ?> </pre>

<h2>Filter BBCode applied, HTML</h2>
<p> <?= $filteredBbcodeText ?> </p>

