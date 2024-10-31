<?php

use PHPUnit\Framework\TestCase;
use Censure\Censure;
use Censure\patterns\PatternsEn;
require_once("Censure.class.php");


class CensureEnTest extends TestCase
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
        $testLines = [];
        $testPatterns = PatternsEn::$patterns;

        foreach ($testPatterns as $p) {
            $testEnding = 'es';
            $replace = ', ';
            $a = preg_replace('/\[a-z]\+|[A-Z]\+/iu', $testEnding, $p);
            $testLine = preg_replace('/\|/iu', $replace, $a);
            $words = explode($replace, $testLine);
            $expectedArr = [];

            for ($a = 0; $a < count($words); $a++) {
                array_push($expectedArr, '***');
            }
            $expected = implode($replace, $expectedArr);

            array_push($testLines, array($testLine, true, $expected));
            echo "test log testLine: " . $testLine . " / expected: " . $expected ." \n\r";
        }
        return $testLines;
    }
}
