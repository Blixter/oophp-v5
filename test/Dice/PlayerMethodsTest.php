<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerMethodsTest extends TestCase
{
    /**
     * Construct object and verify that the method 'addScore' 
     * work as expected.
     */
    public function testAddScore()
    {
        $player = new Player();

        $exp = 5;
        $player->addScore($exp);

        $res = $player->getScore();
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the method 'rollDices' 
     * work as expected.
     */
    public function testRollDices()
    {
        $player = new Player(1);

        $player->rollDices();
        $res = $player->getLastRollSum();

        $this->assertTrue($res <= 100 && $res > 0);
    }

    /**
     * Construct object and verify that the method 'getLastRoll' 
     * work as expected.
     */
    public function testGetLastRoll()
    {
        $exp = 5;
        $player = new Player($exp);

        $player->rollDices();
        $res = sizeof($player->getLastRoll());
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the method 'checkIfRolledOne' 
     * work as expected.
     */
    public function testCheckIfRolledOne()
    {
        $player = new Player(100);

        $player->rollDices();

        $this->assertTrue($player->checkIfRolledOne());
    }
}
