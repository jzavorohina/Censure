<?php

namespace Censure;

use Censure\patterns\PatternsRu;
use Censure\patterns\PatternsEn;
use Censure\patterns\PatternsReplaceRu;

/**
 * ////////////////////
 * // CENSURE class///
 * //////////////////
 * 
 * Dirty words - filter.  
 * 
 * A PHP class to filter out dirty, vulgar, obscene, profane words in russian or english texts.
 * 
 * Key features:
 * - Find profanity (in Russian and English texts) and hide it with *** symbols.
 * - Find profanity (in Russian texts) and replace it with normative vocabulary.
 *
 * Some examples:
 * Censure::is_bad('Original text with abusive words'); // return: bool
 * Censure::replace('Original text with abusive words'); // return: string (text without abusive words)
 * Censure::cleanPost('Unlimited number of arguments to match indexes in $_POST to clean'); // return: void
 * Censure::fix('Original phrase with abusive words'); // return: string (fixed text)
 *
 * @author jzavorohina@yandex.ru
 * 
 * List of replacements - by the book "Русский мат.Толковый словарь." Составитель Ахметова Т.В., Москва "КОЛОКОЛ-ПРЕСС", 2000
 * 
 */

class Censure
{
	const REPLACEMENT = '***';

	/**
	 * Searches if there any abusive words in the text
	 *
	 * @param string $string - original text
	 * @return boolean - is there any abusive words in our string
	 * @todo add a count of the number of bad words in a sentence
	 */
	public static function is_bad($string)
	{
		$patterns = self::getPatterns($string);
		foreach ($patterns as $p) {
			if (preg_match(self::prepare($p), $string))
				return true;
		}
		return false;
	}

	/**
	 * Replace abusive words from string
	 *
	 * @param string $string - original text	 
	 * @return string - cleaned text
	 */
	public static function replace($string)
	{
		$words = explode(' ', $string);
		foreach ($words as $key => $w) {
			$patterns = self::getPatterns($w);
			foreach ($patterns as $p) {
				$pattern = self::prepare($p);
				if (preg_match($pattern, $w)) {
					$words[$key] = preg_replace(self::prepare('[\w\-]+'), self::REPLACEMENT, $words[$key]);
					break;
				}
			}
		}
		return implode(' ', $words);
	}

	/**
	 * Clean indexes in $_POST from abusive words 
	 *
	 * @param mixed  $data,... unlimited number of arguments to match indexes in $_POST to clean
	 * @return void
	 */
	public static function cleanPost()
	{
		$data = func_get_args();
		foreach ($data as $index) {
			if (isset($_POST[$index])) {
				$_POST[$index] = self::replace($_POST[$index]);
			}
		}
	}

	/**
	 * Fixing abusive words inside string
	 * 
	 * @param string $string - original text	 
	 * @return string - fixed text
	 */
	public static function fix($string)
	{
		$result = "";
		$patterns = array_reverse(PatternsReplaceRu::$patterns);

		foreach ($patterns as $p => $replace) {
			$pattern = self::prepare($p);
			if (preg_match($pattern, $string)) {
				$result = preg_replace($pattern, $replace, $string);

				if (self::checkFirstChar($string)) {
					$result = self::upFirstChar($result);
				}
			}
		}
		return $result;
	}

	private static function prepare($pattern)
	{
		return '/' . $pattern . '/iu';
	}

	private static function getPatterns($string)
	{
		if (preg_match(self::prepare("[а-я]+"), $string)) {
			return PatternsRu::$patterns;
		} else if (preg_match(self::prepare("[a-z]+"), $string)) {
			return PatternsEn::$patterns;
		} else {
			return array();
		}
	}

	private static function checkFirstChar($string)
	{
		$first = mb_substr($string, 0, 1, "UTF-8");
		return (mb_strtolower($first) !== $first);
	}

	private static function upFirstChar($string)
	{
		$words = explode(' ', $string);
		$words[0] = mb_convert_case($words[0], MB_CASE_TITLE, "UTF-8");
		return implode(' ', $words);
	}
}
