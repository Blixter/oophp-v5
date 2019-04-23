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
}
