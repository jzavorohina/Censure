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

// 0 Backward compatibility (Ass)
// is_bad: bool(true)
// replace: ***
test('0 Backward compatibility', 'Ass', true, '***');

// 1 A (Ass / arse, asshole / arsehole) 
// is_bad: bool(true)
// replace: *** / ***, *** / ***
test('1 A', 
'Ass / arse, asshole / arsehole', true, '*** / ***, *** / ***');

// 2 B (Bastard, berk, bitch / bitching, blighter, blimey, bollocks, bugger, bullshit, butt)
// is_bad: bool(true)
// replace: ***, ***, *** / ***, ***, ***, ***, ***, ***, *** 
test('2 B', 
'Bastard, berk, bitch / bitching, blighter, blimey, bollocks, bugger, bullshit, butt', true, '***, ***, *** / ***, ***, ***, ***, ***, ***, ***');

// 3 C (Cad, cock / poppycock / cocksucker, crap, cunt)
// is_bad: bool(true)
// replace: ***, *** / *** / ***, ***, ***
test('3 C', 
'Cad, cock / poppycock / cocksucker, crap, cunt', true, 
'***, *** / *** / ***, ***, ***');

// 4 D (Damn, dang, darn, douchebag, dick / dickhead, duffer, dumd)
// is_bad: bool(true)
// replace: ***, ***, ***, ***, *** / ***, ***, ***
test('4 D',
'Damn, dang, darn, douchebag, dick / dickhead, duffer, dumd', true,
'***, ***, ***, ***, *** / ***, ***, ***');

// 5 F (Faggot / fag, fool, freak / freaking, fuck / motherfucker / fucking / fucked)
// is_bad: bool(true)
// replace: *** / ***, ***, *** / ***, *** / *** / *** / ***
test('5 F', 
'Faggot / fag, fool, freak / freaking, fuck / motherfucker / fucking / fucked', true,
'*** / ***, ***, *** / ***, *** / *** / *** / ***');

// 6 G (Gay)
// is_bad: bool(true)
// replace: ***
test('6 G', 
'Gay', true, '***');

// 7 H (Hoe, homo, heck)
// is_bad: bool(true)
// replace: ***, ***, ***
test('7 H', 
'Hoe, homo, heck', true, '***, ***, ***');

// 8 I (Idiot)
// is_bad: bool(true)
// replace: ***
test('8 I', 
'Idiot', true, '***');

// 9 J (Jerk / jerking)
// is_bad: bool(true)
// replace: *** / ***
test('9 J', 'Jerk / jerking', true, '*** / ***');

// 10 K (Knobend)
// is_bad: bool(true)
// replace: ***
test('10 K', 
'Knobend', true, '***');

// 11 L (Loser)
// is_bad: bool(true)
// replace: ***
test('11 L', 
'Loser', true, '***');

// 12 M (Motherfucker)
// is_bad: bool(true)
// replace: ***
test('12 M', 
'Motherfucker', true, '***');

// 13 N (Nerd, nigger)
// is_bad: bool(true)
// replace: ***, ***
test('13 N',
'Nerd, nigger', true, '***, ***');

// 14 P (Pillock, plonker, poo / poop, prat, prick, pussy)
// is_bad: bool(true)
// replace: ***, ***, *** / ***, ***, ***, ***
test('14 P',
'Pillock, plonker, poo / poop, prat, prick, pussy', true, 
'***, ***, *** / ***, ***, ***, ***');

// 15 R (Rotter)
// is_bad: bool(true)
// replace: ***
test('15 R',
'Rotter', true, '***');

// 16 S (Shit / shits / bullshit / shitting / ballshitter, slut, stupid, suck / sucker, swive / swivel, swine)
// is_bad: bool(true)
// replace: *** / *** / *** / *** / ***, ***, ***, *** / ***, *** / ***, ***
test('16 S',
'Shit / shits / bullshit / shitting / ballshitter, slut, stupid, suck / sucker, swive / swivel, swine', true, 
'*** / *** / *** / *** / ***, ***, ***, *** / ***, *** / ***, ***');

// 17 T (Twat)
// is_bad: bool(true)
// replace: ***
test('17 T',
'Twat', true, '***');

// 18 W (Wanker, whore)
// is_bad: bool(true)
// replace: ***, ***
test('18 W',
'Wanker, whore', true, '***, ***');