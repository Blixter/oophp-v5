<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?><h1 class="game header">Play the game</h1>

<div class="aligner">
    <div class="aligner-item">
<?php if (isset($res) && $res == "CORRECT") : ?>
<p>You won the game!</p>
<?php elseif ($tries <= 0) : ?>
<p>Game Over!</p>

<?php else : ?>
<p>Guess a number between 1 and 100.</p>
<p>You have <b><?= $tries ?></b> guesses left.</p>
<?php endif; ?>

<form method="POST">
    <input class="game number" type="number" name="guess">
    <input class="game submit" type="submit" name="doGuess" value="Guess"
<?php if ($tries <= 0 || isset($res) && $res == "CORRECT") : ?> disabled
<?php endif; ?>>
</form>

<form method="POST" action="./cheat">
    <input type="submit" class="game submit" name="doCheat" value="Cheat"
<?php if ($tries <= 0 || isset($res) && $res == "CORRECT") : ?> disabled
<?php endif; ?>>
</form>

<form method="POST" action="./restart">
    <input class="game submit" type="submit" name="doInit" value="Restart">
</form>


<?php if ($res) : ?>
    <p>Your guess <?= $guess ?> is <b><?= $res ?></b></p>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>CHEAT: Current number is <?= $number ?>.</p>
<?php endif; ?>
    </div>
</div>
