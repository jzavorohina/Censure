<?php
////////////////////
// CENSURE CLASS //
//////////////////

/**
 * @author jzavorohina@yandex.ru
 *  
 * Dirty words - filter.
 * 
 * Filter out vulgar, obscene, profane words in Russian/English texts.
 * 
 * Key features:
 * - Fully covers the profanity words.
 *
 * Some examples:
 *
 * Censure::is_bad('Original text with abusive words'); // return: bool
 * Censure::replace('Original text with abusive words'); // return: string (text without abusive words)
 * Censure::cleanPost('Unlimited number of arguments to match indexes in $_POST to clean'); // return: void
 */
 
class Censure {
	
	const REPLACEMENT = '***';

	/**
	 * Set array of russian abusive words
	 */
	 
	public static $patterns_ru = array(
	    'анал[а-я]+|анус|анус[а-я]+',
		'бзд[а-я]+','бля|бля[а-я]+',
		'вафел|вафлер|вафлёр|вафлер[а-я]+|вафлёр[а-я]+|вафле[а-я]+|вафлист|вафли[а-я]+|вафлист[а-я]+',
		'вошка|вошь','вздроч[а-я]+|вздрач[а-я]+',
		'вманд[а-я]+|вмуд[а-я]+',
		'впенд[а-я]+|впиз[а-я]+|пиз[а-я]+',
		'вхуя[а-я]+|вхуй[а-я]+|вхуй[а-я]+',
		'въеб[а-я]+|въебё[а-я]+|выеб[а-я]+|выёб[а-я]+',
		'высер|[а-я]+высер',
		'говн[а-я]+|говен[а-я]+|говён[а-я]+',
		'голощелка','гомос[а-я]+|гомик[а-я]+|гомик','гондон|гондон[а-я]+','гумозник',
		'давалка|даваха','дерьм[а-я]+','дилдо','додик','доеб[а-я]+','дойки','долбан[а-я]+|долбежка|долбоеб[а-я]+', 
		'допиз[а-я]+','досос[а-я]+|досас[а-я]+','доснашив[а-я]+|доснош[а-я]+','досикат[а-я]+|досикив[а-я]+','досир[а-я]+|доусеру|доусрач[а-я]+',
		'дрист[а-я]+|[а-я]+дрис[а-я]+','дроч[а-я]+|драч[а-я]+|[а-я]+дроч[а-я]+|дрюч[а-я]+','дуплиться',
		'еба[а-я]+','ебеня|ебен[а-я]+','ебл[а-я]+','ебнут[а-я]+','ерепени[а-я]+','eдрёна[а-я]+|едрить|едрить[а-я]+','елда','ерунд[а-я]+','ёб[а-я]+',
		'жид|жид[а-я]+','жопа|жоп[а-я]+|жопник|жопочник|жопошник', 
		'забулдыга','загадить','зад|задница','задрот|задрот[а-я]+','заноза','зануда','зараза',
		'засранец|засран[а-я]+|засеря','затычка',
		'идиот|идиот[а-я]+','изманд[а-я]+','йух',
		'карга','клитор','кобель|кобел[а-я]+','кретин','курва',
		'лох|лох[а-я]+','лахудра','легавый','лупоглазый',
		'манд[а-я]+|манда|монда|монда[а-я]+','маразматик','мегера','мент','мерзавец','мразь',
		'мудак|мудило|мудил[а-я]+|мудозвон|мудох[а-я]+',
		'наёб[а-я]+|наеб[а-я]+','ничтожество', 
		'обалдуй','обосранец|обосра[а-я]+','образина','остолоп','отребье|отрепье','отродье','охуе[а-я]+',
		'падаль|падла','паскуда|паскудный','потаскуха','паразит','пентюх','перечница','пизд[ая]+|пизда|[а-я]+пиз[а-я]+',
		'подонок','подстилка','позорник','порнуха','полудурок','потаскун|потаскуха','придурок','прихвостень','прорва',
		'пройдоха','проститутка','прохвост','прохиндей','проходимец','пустобрёх|пустозвон|пустомеля','пьянчуга|пьянь',
		'разъеб[а-я]+','раздолбай','распизд[а-я]+','рвань','ренегат','рогоносец',
		'сброд','сволочь','соси|соса[а-я]+','срать','ссать','стерва','сука|сукин|сучка',
		'тварь','тёлка','толстозадый','тошнотворное','трах[ая]+','трепотня','тряпка','тупица|тупоголовый|туполобый|тупоумный','тягомотину',
		'ублюдок','ублюд[а-я]+','уеб[а-я]+','уебище','урод','урод[а-я]+',
		'фаллос','фефела|фефёла|фефёлка','фофан','фуфло|фуфл[а-я]+',
		'хайло','халда','[а-я]+хера','хлюст','хмырь','холуй|холуйство|холуйств[а-я]+','хрен|хреновина','хрыч',
		'хуй|хуя|[а-я]+охуя','охуе[а-я]+','хуле','хуяк[а-я]+|хуяр[а-я]+|хуяч[а-я]+',
		'целка','черножопый|чернозадый|черномазый','чинодрал','чмо','чурбан','чучело',
		'шалава','шалашовка','шантрапа','шаромыжник','шваль','шизоид','шлюха|шлюш[а-я]+','шушера',
		'щекотильник','эрекция','юлда|юлдак','ядрёна|ядрена','ядрить'
	);

	/**
	 * Set array of english abusive words
	 */

	public static $patterns_en = array(
		'ass|arse','asshole|arsehole',
		'bastard','berk','bitch|bitch[a-z]+','blighter','blimey','bollocks','bugger','bullshit','butt', 
		'cad','cock|[a-z]+cock|cock[a-z]+','crap','cunt', 
		'damn','dang','darn','douchebag','dick|dick[a-z]+','duffer','dumd', 
		'faggot|fag','fool','freak|freaking ','fuck|[a-z]+fucker|fucking| fucked',
		'gay',
		'hoe','homo','heck',
		'idiot',
		'jerk|jerking',
		'knob[a-z]+',
		'loser',
		'motherf[a-z]+',
		'nerd','nigger',
		'pillock','plonker','poo|poop','prat','prick','pussy',
		'rotter', 
		'shit|shits|[a-z]+shit|shit[a-z]+|[a-z]+shit[a-z]+','slut','stupid','suck|sucker','swive|swivel','swine', 
		'twat',
		'wanker','whore'
	);
	 
	/**
	 * Replace abusive words from string
	 *
	 * @param string $string - original text	 
	 * @return string - cleaned text
	 */	
	 
	 public static function replace ( $string ) {
		$words = explode(' ',$string);
		foreach ($words as $key=>$w) {
			$patterns = self::getPatterns($w);
			foreach ($patterns as $p) {
				$pattern = self::prepare($p);
				if(preg_match($pattern, $w)) {
					$words[$key] = preg_replace(self::prepare('[\w\-]+'), self::REPLACEMENT, $words[$key]) ;
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

	public static function cleanPost () {
		$data = func_get_args();
		foreach($data as $index) {
			if(isset($_POST[$index])) {
				$_POST[$index] = self::replace($_POST[$index]);
			}
		}
	}

	/**
	 * Searches if there any abusive words in the text . 
	 *
	 * @param string $string - original text
	 * @return boolean - is there any abusive words in our string
	 */

	public static function is_bad ( $string ) {
		$patterns = self::getPatterns($string);
		foreach ($patterns as $p) {
			if(preg_match(self::prepare($p),$string)) return true;
		}
		return false; 
	}

	private static function prepare ( $pattern ) {
		return '/'.$pattern.'/iu';
	}

	private static function getPatterns( $string ) {
			if (preg_match(self::prepare("[а-я]+"), $string)){
				return self::$patterns_ru;
			} else if (preg_match(self::prepare("[a-z]+"), $string)){
				return self::$patterns_en;
			} else {
				return array();
			}			
	}

}