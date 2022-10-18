<?php
require('Censure.class.php');

function testIsBad($title, $text, $check) {
    $start = microtime(true);
    $result = Censure::is_bad($text);
    echo $title . " (". $text. ") is_bad: ";
    var_dump($result);
    $end = microtime(true);
    echo "time: " . number_format(microtime(true) - $start, 10) . "\n";
    return !!($check === $result);
}

function testReplace($title, $text, $check) {
    echo $title . " (". $text. ") is_bad: ";
    $start = microtime(true);
    $result = Censure::replace($text);
    echo "replace: " . $result . "\n";
    $end = microtime(true);
    echo "time: " . number_format(microtime(true) - $start, 10) . "\n";
    return !!($check === $result);
}

function test($title, $text, $isBad, $replace) {
    if (testIsBad($title, $text, $isBad) && testReplace($title, $text, $replace)) {
        echo "test is passed! V\n\n";
    } else {
        echo "test is not passed! X\n\n";
    }
}

// 0 Backward compatibility (Ass - это задница, жопа)
// is_bad: bool(true)
// replace: *** - это ***, ***
test('0 Backward compatibility', 'Ass - это задница, жопа', true, '*** - это ***, ***');

// 1 A (Анальная, анус, анусе, ass / arse, asshole / arsehole) 
// is_bad: bool(true)
// replace: ***, ***, ***, *** / ***, *** / ***
test('1 A', 
'Анальная, анус, анусе, ass / arse, asshole / arsehole', true, '***, ***, ***, *** / ***, *** / ***');