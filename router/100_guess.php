<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // init the session for the gamestart.
    $game = new Blixter\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();

    return $app->response->redirect("guess/play");
});


/**
 * Play the game - show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    // Get current settings from the SESSION
    $doCheat = $_SESSION["doCheat"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $guess = $_SESSION["guess"] ?? null;
    $number = $_SESSION["number"];
    $_SESSION["res"] = null;
    $_SESSION["guess"] = null;
    $_SESSION["doCheat"] = null;

    $data = [
        "guess" => $guess ?? null,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat ?? null,
        "res" => $res,
        "tries" => $tries,
        "number" => $number,
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game - make a guess
 */
$app->router->post("guess/play", function () use ($app) {
    $title = "Play the game";

    // Incoming variables
    $guess = $_POST["guess"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;

    // Get current settings from the SESSION
    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;

    if ($doGuess) {
        // Do a guess
        $game = new Blixter\Guess\Guess($number, $tries);
        $res = $game->makeGuess($guess);
        $_SESSION["tries"] = $game->tries();
        $_SESSION["res"] = $res;
        $_SESSION["guess"] = $guess;
    }
    return $app->response->redirect("guess/play");
});

/**
 * Save cheat to session
 */
$app->router->post("guess/cheat", function () use ($app) {
    $_SESSION["doCheat"] = "cheat";
    return $app->response->redirect("guess/play");
});

/**
 * Restart the game by redirecting to guess/init
 */
$app->router->post("guess/restart", function () use ($app) {
    return $app->response->redirect("guess/init");
});
