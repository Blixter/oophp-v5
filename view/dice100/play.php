<?php

namespace Anax\View;

include "variables.php";
?>

<h1>Dice 100</h1>
<hr>
<p>Players Total Score: <b><?= $playerScore ?></b></p>
<p>Computers Total Score: <b><?= $computerScore ?></b>
<?php if ($playerScore >= 100) : ?>
<p class="green"><b>You won the game!</b></p>
<?php elseif ($computerScore >= 100) : ?>
<p class="red"><b>The computer won the game!</b></p>
<?php endif; ?>
<hr>
<?php if (isset($histogram)) : echo("<pre><b>Histogram</b><br>" . 
    $histogram->getAsText() . "</pre>"); ?>
<?php endif; ?>
<p>Score this round: <b><?= $roundScore ?></b></p>
<p>Current turn: <b><?= ucwords($roundTurn) ?></b></p>
<hr>
<p>
    <?php if (isset($lastRoundTurn) && $started == true) :
        echo(ucwords($lastRoundTurn) . " rolled:<p>");
        ?>
    <?php endif; ?>
<?php if (isset($lastRoll)) : foreach ($lastRoll as $value) : ?>
    <i class="dice-sprite dice-<?= $value ?>"></i>
<?php endforeach; ?>
    <?php if (($lastRoundTurn == "player")) : ?>
    <p>Sum:  <b><?= $playerSum ?></b></p>
    <?php elseif (($lastRoundTurn == "computer")) : ?>
<p>Sum:  <b><?= $computerSum ?></b></p>
    <?php endif; ?>
<?php endif; ?>
<?php if (($choice == "save")) : ?>
    <p><b>Computer choose to save points.</b></p>
<?php endif; ?>


<form method="POST" action="./player">
    <input class="game submit" type="submit" name="playerRoll" value="Roll dices"
    <?php if ($roundTurn == "computer"
    || $computerScore >= 100
    || $playerScore >= 100
    || $choosedDices == false) : ?> hidden
    <?php endif; ?>>
</form>
<form method="POST" action="./player-save">
    <input class="game submit" type="submit" name="playerSave" value="Save"
    <?php if ($roundTurn == "computer" || $roundScore == 0) : ?> hidden
    <?php endif; ?>>
</form>
<form method="POST" action="./computer">
    <input class="game submit" type="submit" name="computerRoll" value="Simulate computer roll"
    <?php if ($roundTurn == "player"
        || $computerScore >= 100
        || $playerScore >= 100) : ?> hidden
    <?php endif; ?>>
</form>
<form action="./init">
    <input class="game submit" type="submit" name="restart" value="Restart"
    <?php if ($computerScore < 100
        && $playerScore < 100) : ?> hidden
    <?php endif; ?>>
</form>
<form method="GET" action="./dices">
    <select class="game option" name="dices"<?php if ($started == true
    || $choosedDices == true) : ?> hidden
                                            <?php endif; ?>>>
        <option class="game" value="1">1 dice</option>
        <option class="game" value="2">2 dices</option>
        <option class="game" value="3">3 dices</option>
        <option class="game" value="4">4 dices</option>
        <option class="game" value="5">5 dices</option>
        <option class="game" value="6">6 dices</option>
        <option class="game" value="7">7 dices</option>
        <option class="game" value="8">8 dices</option>
        <option class="game" value="9">9 dices</option>
        <option class="game" value="10">10 dices</option>
    <input class="game submit" type="submit" name="doIt" value="Choose dices"
    <?php if ($started == true
    || $choosedDices == true ) : ?> hidden
    <?php endif; ?>>
</form>
