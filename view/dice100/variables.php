<?php

// Get variables
$game = $app->session->get("game");

$lastRoll =  $app->session->get("lastRoll");
$playerScore = $game->player->getScore();
$computerScore = $game->computer->getScore();
$playerSum = $game->playerSum();
$computerSum = $game->computerSum();
$roundTurn = $game->getRoundTurn();
$roundScore = $game->getRoundScore();
$lastRoundTurn = $app->session->get("lastRoundTurn") ?? null;
$choice = $app->session->get("choice") ?? "nothing";
$app->session->set("choice", null);
$started = $game->started;
$choosedDices = $app->session->get("choosedDices");
