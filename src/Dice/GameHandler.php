<?php
namespace Blixter\Dice;

/**
 * Handler of the game
 */
class GameHandler
{
    /**
     * @var int $currentRoundScore   Score in the game.
     * @var str $currentRoundTurn current players turn in the game.
     * @var int $numberOfDices Amount of dices used in the game.
     * @var bool $started Check if the game has started or not, default to false.
     */
    private $currentRoundScore;
    private $currentRoundTurn;
    private $numberOfDices;
    public $started = false;

    /**
     * Constructor to the players.
     * Create one human player and one computer player.
     * Set currentRoundScore to 0.
     */
    public function __construct()
    {
        $this->numberOfDices = 5;
        $this->computer = new ComputerPlayer($this->numberOfDices);
        $this->player = new Player($this->numberOfDices);
        $this->currentRoundScore = 0;
        $this->currentRoundTurn = "player";
    }

    /**
     * Reset the computers dices first.
     * Then the player roll the dices in hand and return the values
     * @return array with value of the rolls
     */
    public function playerTurn()
    {
        $this->started = true;
        $this->computer->dices = new DiceHandHistogram($this->numberOfDices);
        $this->player->rollDices();
        // if the player rolled one, change the turn to computer and return
        if ($this->player->checkIfRolledOne() == true) {
            $this->setRoundTurn("computer");
            $this->resetRoundScore();
            return $this->player->getLastRoll();
        }
        // if the player didnt roll one, add the sum of the dices
        // to the currentRoundScore.
        $this->addRoundScore($this->playerSum());
        return $this->player->getLastRoll();
    }

    /**
     * Return sum of last roll.
     * @return int with sum of the dices
     */
    public function playerSum()
    {
        return $this->player->getLastRollSum();
    }

    /**
     * Return sum of last roll
     * @return int with sum of the dices
     */
    public function computerSum()
    {
        return $this->computer->getLastRollSum();
    }

    /**
     * Reset the players dices first.
     * Then the computer roll the dices in hand and return the values
     * @return array with value of the rolls
     */
    public function computerTurn()
    {
        $this->player->dices = new DiceHandHistogram($this->numberOfDices);
        $this->computer->rollDices();
        // if the computer rolled one, change the turn to player and return
        if ($this->computer->checkIfRolledOne() == true) {
            $this->setRoundTurn("player");
            $this->resetRoundScore();
            return $this->computer->getLastRoll();
        }
        // if the computer didnt roll one, add the sum of the dices
        // to the currentRoundScore.
        $this->addRoundScore($this->computerSum());
        return $this->computer->getLastRoll();
    }

    /**
     * Save the computers current round score to total score.
     * Changes the turn to the player and reset the round score.
     * @return void
     */
    public function computerSaveScore()
    {
        $this->computer->addScore($this->getRoundScore());
        $this->setRoundTurn("player");
        $this->resetRoundScore();
    }

    /**
     * Save the player current round score to total score.
     * Changes the turn to the computer and reset the round score.
     * @return void
     */
    public function playerSaveScore()
    {
        $this->player->addScore($this->getRoundScore());
        $this->setRoundTurn("computer");
        $this->resetRoundScore();
    }

    /**
     * Add to the current round score
     * @param int $roundScore Add score to this rounds score.
     * @return void
     */
    public function addRoundScore($roundScore)
    {
        $this->currentRoundScore = $this->currentRoundScore + $roundScore;
    }

    /**
     * Get current round score
     * @return int current round score.
     */
    public function getRoundScore()
    {
        return $this->currentRoundScore;
    }

    /**
     * Get current round turn.
     * @return str current round player (computer or player).
     */
    public function getRoundTurn()
    {
        return $this->currentRoundTurn;
    }

    /**
     * Change who's turn in the game it is
     * @param str $roundTurn Change current player
     * @return void
     */
    public function setRoundTurn($roundTurn)
    {
        $this->currentRoundTurn = $roundTurn;
    }

    /**
     * Reset current round score.
     * @return void
     */
    public function resetRoundScore()
    {
        $this->currentRoundScore = 0;
    }

    /**
     * Decides if the computer will save or continue
     * @return str "save"
     */
    public function saveOrContinue()
    {
        $toDo = $this->computer->makeDecision();
        if ($toDo == "save") {
            $this->computerSaveScore();
            return "save";
        }
    }

    /**
     * Set the number of dices
     * @param int $dices number of dices to play with.
     * @return void
     */
    public function setNumberOfDices($dices)
    {
        $this->numberOfDices = $dices;
        $this->computer = new ComputerPlayer($dices);
        $this->player = new Player($dices);
    }
}
