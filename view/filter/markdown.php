<?php
namespace Anax\View;

?><!doctype html>
<html>
<meta charset="utf-8">
<title>Show off Markdown</title>

<h1>Showing off Markdown</h1>

<h2>Markdown source in sample.md</h2>
<pre><?= $markdownText ?></pre>

<h2>Text formatted as HTML source</h2>
<pre><?= htmlentities($filteredMarkdownText) ?></pre>

<h2>Text displayed as HTML</h2>
<?= $filteredMarkdownText ?>
