<?php

use PHPUnit\Framework\TestCase;
require_once("Censure.class.php");

class CensureMixTest extends TestCase
{

    /**
     * @dataProvider providerPower
     */
    public function testFix($text, $isBadExpected, $textExpected)
    {
        $isBad = Censure::is_bad($text);
        $replace = Censure::replace($text);
        $this->assertEquals($isBadExpected, $isBad);
        $this->assertEquals($textExpected, $replace);
    }

    public function providerPower()
    {
        return array(
            array('Ass - это задница, жопа', true, '*** - это ***, ***'),
            array('Анальная, анус, анусе, ass / arse, asshole / arsehole', true, '***, ***, ***, *** / ***, *** / ***')
        );
    }
}
