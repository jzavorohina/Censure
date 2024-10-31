<?php

use PHPUnit\Framework\TestCase;
use Censure\Censure;
use Censure\patterns\PatternsRu;
require_once("Censure.class.php");

class CensureRuTest extends TestCase
{

    /**
     * @dataProvider providerPower
     * @todo add independence from extra spaces
     * @todo make more convenient tests
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
        $testLines = [];
        $testPatterns = PatternsRu::$patterns;

        foreach ($testPatterns as $p) {
            $testEnding = 'ились';
            $replace = ', ';
            $a = preg_replace('/\[а-я\]\+|\[а-яё\]\+/iu', $testEnding, $p);
            $testLine = preg_replace('/\|/iu', $replace, $a);
            $words = explode($replace, $testLine);
            $expectedArr = [];

            for($a = 0 ; $a < count($words) ; $a++) {
                array_push($expectedArr, '***');
            }

            $expected = implode($replace, $expectedArr);

            array_push($testLines, array($testLine, true, $expected));
        }

        return $testLines;
    }
}
