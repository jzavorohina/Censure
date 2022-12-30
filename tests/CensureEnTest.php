<?php

use PHPUnit\Framework\TestCase;
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
        return array(
            array('Ass', true, '***'),
            array('Ass / arse, asshole / arsehole', true, '*** / ***, *** / ***'),
            array('Bastard, berk, bitch / bitching, blighter, blimey, bollocks, bugger, bullshit, butt', true, '***, ***, *** / ***, ***, ***, ***, ***, ***, ***'),
            array('Cad, cock / poppycock / cocksucker, crap, cunt', true, '***, *** / *** / ***, ***, ***'),
            array('Damn, dang, darn, douchebag, dick / dickhead, duffer, dumd', true, '***, ***, ***, ***, *** / ***, ***, ***'),
            array('Faggot / fag, fool, freak / freaking, fuck / motherfucker / fucking / fucked', true, '*** / ***, ***, *** / ***, *** / *** / *** / ***'),
            array('Gay', true, '***'),
            array('Hoe, homo, heck', true, '***, ***, ***'),
            array('Idiot', true, '***'),
            array('Jerk / jerking', true, '*** / ***'),
            array('Knobend', true, '***'),
            array('Loser', true, '***'),
            array('Motherfucker', true, '***'),
            array('Nerd, nigger', true, '***, ***'),
            array('Pillock, plonker, poo / poop, prat, prick, pussy', true, '***, ***, *** / ***, ***, ***, ***'),
            array('Rotter', true, '***'),
            array('Shit / shits / bullshit / shitting / ballshitter, slut, stupid, suck / sucker, swive / swivel, swine', true, '*** / *** / *** / *** / ***, ***, ***, *** / ***, *** / ***, ***'),
            array('Twat', true, '***'),
            array('Wanker, whore', true, '***, ***')
        );
    }
}
