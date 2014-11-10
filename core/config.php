<?php

class Config{
	
	private static $data = [];
	
	public function __construct() {
		
		$default = parse_ini_file(CONFIG.'/general.ini', true);
		self::$data = $default;
		
		date_default_timezone_set(self::get('app.timezone'));
		
	}
	
	public static function get($element){

		$sections = explode('.', $element);
		$select =& self::$data;
		
		if(!isset(self::$data[$sections[0]]) and file_exists(CONFIG."/{$sections[0]}.ini")):
			self::$data[$sections[0]] = parse_ini_file(CONFIG."/{$sections[0]}.ini", true);
		endif;
		
		foreach($sections as $section):
			if((array)$select === $select and isset($select[$section])):
				$select =& $select[$section];
			else:
				return null;
			endif;
		endforeach;
		
		return $select;
				
	}
	
	public static function set($element, $value){
		
		$sects = explode('.', $element);
		$select =& self::$data;
		
		foreach($sects as $section):
			if((array)$select === $select and isset($select[$section])):
				$select =& $select[$section];
			else:
				$select[$section] = [];
				$select =& $select[$section];
			endif;
		endforeach;
		
		$select = $value;
				
	}
	
}
