<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Player.
 */
class PlayerCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $player = new Player();
        $this->assertInstanceOf("\Blixter\Dice\Player", $player);

        $res = $player->dices->amountOfDices();
        $exp = 5;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testCreateObjectOneArguments()
    {
        $exp = 6;
        $player = new Player($exp);
        $this->assertInstanceOf("\Blixter\Dice\Player", $player);

        $res = $player->dices->amountOfDices();
        $this->assertEquals($exp, $res);
    }
}
