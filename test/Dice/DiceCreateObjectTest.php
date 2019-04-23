<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Blixter\Dice\Dice", $dice);

        $res = $dice->sides;
        $exp = 6;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testCreateObjectOneArguments()
    {
        $exp = 4;
        $dice = new Dice($exp);
        $this->assertInstanceOf("\Blixter\Dice\Dice", $dice);

        $res = $dice->sides;
        $this->assertEquals($exp, $res);
    }

    /**
     * Construct object and verify that the object has the expected
     * properties. Use one argument.
     */
    public function testGetLastRoll()
    {
        $dice = new Dice();
        $exp = $dice->roll();

        $res = $dice->getLastRoll();
        $this->assertEquals($exp, $res);
    }
}
