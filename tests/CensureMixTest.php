<?php

use PHPUnit\Framework\TestCase;
use Censure\Censure;
use Censure\patterns\PatternsRu;
use Censure\patterns\PatternsEn;
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
        $testLines = [];
        $testPatterns = array_merge(PatternsRu::$patterns,PatternsEn::$patterns);

        foreach ($testPatterns as $p) {
            $testEnding = '';
            $validWords = '';

            if (preg_match(("/\[а-я\]\+|\[а-яё\]\+/iu"), $p)) {
                $testEnding = 'ились';
                $validWords = ['это','задница','слово','парк','табуретка','экран','шуфлядка'];
            } else if (preg_match(("/\[a-z]\+|[A-Z]\+/iu"), $p)) {
                $testEnding = 'es';
                $validWords = ['feet','food','ice','sun','moon','zero','date'];
            }

            $replace = ', ';
            $a = preg_replace('/\[а-я\]\+|\[а-яё\]\+|\[a-z]\+|[A-Z]\+/iu', $testEnding, $p);
            $testLine = preg_replace('/\|/iu', $replace, $a);
            $words = explode($replace, $testLine);
            $expectedArr = [];
            $testArr = [];

            for ($a = 0; $a < count($words); $a++) {
                if($a % 2 === 0){
                    array_push($testArr, $validWords[$a]);
                    array_push($expectedArr, $validWords[$a]);
                }
                array_push($testArr, $words[$a]);
                array_push($expectedArr, '***');
            }
            $test = implode($replace, $testArr);
            $expected = implode($replace, $expectedArr);

            array_push($testLines, array($test, true, $expected));
            echo "test log test: " . $test . " / expected: " . $expected ." \n\r";
        }
        return $testLines;
    }
}
