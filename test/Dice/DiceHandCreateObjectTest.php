<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand.
 */
class DiceHandCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\Blixter\Dice\DiceHand", $diceHand);

        $res = $diceHand->amountOfDices();
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
        $diceHand = new DiceHand($exp);
        $this->assertInstanceOf("\Blixter\Dice\DiceHand", $diceHand);

        $res = $diceHand->amountOfDices();
        $this->assertEquals($exp, $res);
    }
}
