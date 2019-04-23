<?php

namespace Blixter\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class ComputerPlayer.
 */
class ComputerPlayerMethodsTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testMakeDecision()
    {
        $computer = new ComputerPlayer();

        $res = $computer->makeDecision();
        $exp = 'string';

        $this->assertInternalType($exp, $res);
    }
}
