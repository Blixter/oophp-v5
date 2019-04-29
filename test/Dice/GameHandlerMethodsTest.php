<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class GameHandlerMethodsTest extends TestCase
{
    /**
     * Construct object and verify that the method 'setNumberOfDices'
     * changes the property correctly.
     */
    public function testNumberOfDices()
    {
        $game = new gameHandler();

        $exp = 3;
        $game->setNumberOfDices($exp);
        $res = $game->player->dices->amountOfDices();

        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the method 'getRoundScore'
     * returns the correct value.
     */
    public function testGetRoundScore()
    {
        $game = new gameHandler();

        // Round score should start at 0.
        $exp = 0;

        $res = $game->getRoundScore();

        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the method 'addRoundScore'
     * changes the property 'currentRoundTurn' correctly.
     */
    public function testAddRoundScore()
    {
        $game = new gameHandler();

        $exp = 5;

        $game->addRoundScore($exp);

        $res = $game->getRoundScore();

        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the method 'resetRoundScore'
     * changes the property 'currentRoundTurn' correctly.
     */
    public function testResetRoundScore()
    {
        $game = new gameHandler();

        // Adding value to roundscore
        $game->addRoundScore(20);

        // Should reset back to 0.
        $game->resetRoundScore();
        $exp = 0;

        $res = $game->getRoundScore();

        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the method 'playerTurn'
     * returns the last roll.
     */
    public function testPlayerTurn()
    {
        $game = new gameHandler();

        for ($i = 0; $i <= 100; $i++) {
            $res = $game->playerTurn();
            if ($game->player->checkIfRolledOne()) {
                $exp = $game->player->getLastRoll();
                $this->assertEquals($exp, $res);
            } else {
                $res = $game->playerTurn();
                $exp = $game->player->getLastRoll();
                $this->assertEquals($exp, $res);
            }
        }
    }

    /**
     * Construct object and verify that the method 'computerTurn'
     * returns the last roll.
     */
    public function testComputerTurn()
    {
        $game = new gameHandler();

        for ($i = 0; $i <= 100; $i++) {
            $res = $game->computerTurn();
            if ($game->computer->checkIfRolledOne()) {
                $exp = $game->computer->getLastRoll();
                $this->assertEquals($exp, $res);
            } else {
                $res = $game->computerTurn();
                $exp = $game->computer->getLastRoll();
                $this->assertEquals($exp, $res);
            }
        }
    }

    /**
     * Construct object and verify that the method 'playerSaveScore'
     * changes the property 'currentRoundScore' correctly.
     */
    public function testPlayerSaveScore()
    {
        $game = new gameHandler();

        $exp = 20;
        // Adding value to roundscore
        $game->addRoundScore($exp);

        // Should reset back to 0.
        $game->playerSaveScore();

        $res = $game->player->getScore();

        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the method 'computerSaveScore'
     * changes the property 'currentRoundScore' correctly.
     */
    public function testComputerSaveScore()
    {
        $game = new gameHandler();

        $exp = 20;
        // Adding value to roundscore
        $game->addRoundScore($exp);

        // Should reset back to 0.
        $game->computerSaveScore();

        $res = $game->computer->getScore();

        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the method 'getRoundTurn'
     * returns the correct player.
     */
    public function testGetRoundTurn()
    {
        $game = new gameHandler();
        
        // Player always starts.
        $exp = "player";

        $res = $game->getRoundTurn();

        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the method 'saveOrContinue'
     * returns a string correctly.
     */
    public function testSaveOrContinue()
    {
        $game = new gameHandler();

        for ($i = 0; $i <= 100; $i++) {
            $game->computer->dices->roll();
            $resArray[] = $game->saveOrContinue();
        }
        $this->assertContains("save", $resArray);
    }
}
