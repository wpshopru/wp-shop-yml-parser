<?php

class ImportYml_Yml
{
	/**
	 * Функция переводит транслирует русский текст в латиницу
	 * 
	 * @param string $string
	 */
	private static function rus2translit($string)
	{
		$converter = array(
				'а' => 'a',   'б' => 'b',   'в' => 'v',
				'г' => 'g',   'д' => 'd',   'е' => 'e',
				'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
				'и' => 'i',   'й' => 'y',   'к' => 'k',
				'л' => 'l',   'м' => 'm',   'н' => 'n',
				'о' => 'o',   'п' => 'p',   'р' => 'r',
				'с' => 's',   'т' => 't',   'у' => 'u',
				'ф' => 'f',   'х' => 'h',   'ц' => 'c',
				'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
				'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
				'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
				'А' => 'A',   'Б' => 'B',   'В' => 'V',
				'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
				'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
				'И' => 'I',   'Й' => 'Y',   'К' => 'K',
				'Л' => 'L',   'М' => 'M',   'Н' => 'N',
				'О' => 'O',   'П' => 'P',   'Р' => 'R',
				'С' => 'S',   'Т' => 'T',   'У' => 'U',
				'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
				'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
				'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
				'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);
		return strtr($string, $converter);
	}
	
	public static function translit($str) {
		// переводим в транслит
		$str = self::rus2translit($str);
		// в нижний регистр
		$str = strtolower($str);
		// заменям все ненужное нам на "-"
		$str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
		// удаляем начальные и конечные '-'
		$str = trim($str, "-");
		return $str;
	}
	
	public static function xmlrefactor($filename)
	{
		$xml = file_get_contents($filename);
		if (preg_match("/YML_CATALOG/",$xml))
		{
			$xml = preg_replace_callback("/<(.+)>/sU",array('ImportYml_Yml','strtolower'), $xml);
			/** Сохраняем файл */
			$f = fopen($filename,'w+');
			fwrite($f,$xml);
			fclose($f);
		}
	}
	
	public static function strtolower($m)
	{
		$str = strtolower($m[0]);
		$str = str_replace("rur","RUR",$str);
		$str = str_replace("parentid","parentId",$str);
		$str = str_replace("categoryid","categoryId",$str);
		return $str; 
	}
}