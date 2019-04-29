<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));

/**
 * Init the game and redirect to play the game.
 */
$app->router->get("dice/init", function () use ($app) {
    // init the session for the gamestart.
    $game = new Blixter\Dice\GameHandler();
    $app->session->set("game", $game);
    $app->session->set("lastRoll", null);
    $app->session->set("roundTurn", null);
    $app->session->set("choosedDices", false);
    $roundTurn = $game->getRoundTurn();
    $app->session->set("choice", "nothing");

    return $app->response->redirect("dice/play");
});

/**
 * Play the game - show game status
 */
$app->router->get("dice/play", function () use ($app) {
    $app->session->set("lastRoundTurn", $app->session->get("roundTurn"));
    $game = $app->session->get("game");
    $title = "Play the game";
    $app->session->set("roundTurn", $game->getRoundTurn());

    $data = [
        "title" => $title,
    ];

    $app->page->add("dice/play", $data);

    return $app->page->render([
        "title" => $title,
        ]);
});


/**
 * Player roll the dices
 */
$app->router->post("dice/player", function () use ($app) {
    // Get the object saved to the session.
    $game = $app->session->get("game");
    $app->session->set("lastRoll", $game->playerTurn());
    $app->session->set("checkRollOne", $game->player->checkIfRolledOne());

    return $app->response->redirect("dice/play");
});

/**
 * Computer roll the dices
 */
$app->router->post("dice/computer", function () use ($app) {
    // Get the object saved to the session.
    $game = $app->session->get("game");

    $app->session->set("lastRoll", $game->computerTurn());
    if ($game->computer->checkIfRolledOne() == false) {
        $app->session->set("choice", $game->saveOrContinue());
    };
    return $app->response->redirect("dice/play");
});

/**
 * Player saves round score to total score
 */
$app->router->post("dice/player-save", function () use ($app) {
    // Get the object saved to the session.
    $game = $app->session->get("game");

    // Add current round score to players total score
    $game->playerSaveScore();
    // Redirect back to game
    return $app->response->redirect("dice/play");
});

/**
* Chooses amount of dices
*/
$app->router->get("dice/dices", function () use ($app) {
    // Get the object saved to the session.
    $game = $app->session->get("game");
    $app->session->set("choosedDices", true);
    $dices = intval($app->request->getGet("dices"));
    $game->setNumberOfDices($dices);

    // Redirect back to game
    return $app->response->redirect("dice/play");
});
