<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerMethodsTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testAddScore()
    {
        $player = new Player();

        $exp = 5;
        $player->addScore($exp);

        $res = $player->getScore();
        $this->assertEquals($exp, $res);
    }
}
