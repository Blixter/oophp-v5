<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class ComputerPlayer.
 */
class ComputerPlayerCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $computer = new ComputerPlayer();
        $this->assertInstanceOf("\Blixter\Dice\ComputerPlayer", $computer);

        $res = $computer->dices->amountOfDices();
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
        $computer = new ComputerPlayer($exp);
        $this->assertInstanceOf("\Blixter\Dice\ComputerPlayer", $computer);

        $res = $computer->dices->amountOfDices();
        $this->assertEquals($exp, $res);
    }
}
