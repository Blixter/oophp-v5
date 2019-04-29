<?php
namespace Blixter\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;
/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;
    /**
     * Add the request method to the method name to limit what request methods
     * the handler supports.
     * GET mountpoint/init
     *
     * @return string
     */
    public function initActionGet() : string
    {
        /**
         * Init the game and redirect to play the game.
         */

        $session = $this->app->session;
        $response = $this->app->response;
        
        $game = new GameHandler();
        
        $session->set("game", $game);
        $session->set("lastRoll", null);
        $session->set("roundTurn", null);
        $session->set("choosedDices", false);
        $session->set("roundTurn", $game->getRoundTurn());
        $session->set("choice", "nothing");
        $session->set("histogram", null);

        return $response->redirect("dice100/play");
    }

    /**
     * Add the request method to the method name to limit what request methods
     * the handler supports.
     * GET mountpoint/dices
     * Choose amount of dices
     *
     * @return string
     */
    public function dicesActionGet() : string
    {
        $session = $this->app->session;
        $response = $this->app->response;
        $request = $this->app->request;

        // Get the object saved to the session.
        $game = $session->get("game");
        $session->set("choosedDices", true);
        $dices = intval($request->getGet("dices"));
        $game->setNumberOfDices($dices);
    
        // Redirect back to game
        return $response->redirect("dice100/play");
    }


    /**
     * This sample method action it the handler for route:
     * GET mountpoint/play
     * Play the game
     * 
     * @return object
     */
    public function playActionGet() : object
    {   
        $session = $this->app->session;
        $page = $this->app->page;
        
        $session->set("lastRoundTurn", $session->get("roundTurn"));
        $game = $session->get("game");
        $title = "Dice 100";
        $session->set("roundTurn", $game->getRoundTurn());

        // $session->set("playerHistogram", $game->getPlayerHistogram());

        $data = [
            "title" => $title,
        ];

        $page->add("dice100/play", $data);

        return $page->render([
            "title" => $title,
        ]);
    }
    /**
     * This sample method action it the handler for route:
     * POST mountpoint/player
     * Player roll the dices
     *
     * @return string
     */
    public function playerActionPost() : string
    {
        $session = $this->app->session;
        $response = $this->app->response;

        // Get the object saved to the session.
        $game = $session->get("game");
        $session->set("lastRoll", $game->playerTurn());
        $session->set("checkRollOne", $game->player->checkIfRolledOne());

        $histogram = new Histogram();
        $histogram->injectData($game->player->dices);
        $session->set("histogram", $histogram);

        return $response->redirect("dice100/play");
    }

    /**
     * This sample method action it the handler for route:
     * POST mountpoint/computer
     * Computer roll the dices
     *
     * @return string
     */
    public function computerActionPost() : string
    {   
        $session = $this->app->session;
        $response = $this->app->response;

        $game = $session->get("game");
        
        $session->set("lastRoll", $game->computerTurn());

        $histogram = new Histogram();
        $histogram->injectData($game->computer->dices);
        $session->set("histogram", $histogram);

        if ($game->computer->checkIfRolledOne() == false) {
            $session->set("choice", $game->saveOrContinue());
        };

        return $response->redirect("dice100/play");
    }

    /**
     * This sample method action it the handler for route:
     * POST mountpoint/playersave
     * Player saves the points
     *
     * @return string
     */
    public function playersaveActionPost() : string
    {   
        $session = $this->app->session;
        $response = $this->app->response;
        // Get the object saved to the session.
        $game = $session->get("game");
    
        // Add current round score to players total score
        $game->playerSaveScore();
        // Redirect back to game
        return $response->redirect("dice100/play");
    }
}
