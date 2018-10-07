<?php
/**
 * @author : YuanZhiHeng
 * @since  : 1.0.0.0
 * @version: 1.0.0.0
 * @license: MIT
 * @date   : 2018/9/28
 */

namespace Can {
	
	
	final class CanLoad
	{
		private static $instance = false;
		
		private static $included = array();
		
		final public function __construct(){}
		
		final public function __clone(){}
		
		final public static function autoload()
		{
			if (self::$instance === false)
			{
				self::ready();
				
				self::$instance =  self::loadCan();
			}
			
			return self::$instance;
		}
		
		final private static function loadCan()
		{
			$classList = array('AbstractCan', 'InterfaceCan', 'InterfaceCanReflection', 'Can');
			
			foreach ($classList as $class)
			{
				if (!in_array($class, self::$included))
				{
					if(preg_match('/(Abstract)/', $class) === 1)
					{
						$file = 'Abstracts' . DIRECTORY_SEPARATOR . $class . '.';
					}
					elseif (preg_match('/(Interface)/', $class) === 1)
					{
						$file = 'Interfaces' . DIRECTORY_SEPARATOR . $class . '.';
					}
					else
					{
						$file = $class . '.class.';
					}
					
					$path = ROOT . DIRECTORY_SEPARATOR . 'Can' .
						DIRECTORY_SEPARATOR . $file . pathinfo(__FILE__, PATHINFO_EXTENSION);
					
					file_exists($path)? require_once $path : null;
					
					array_push(self::$included, $class);
				}
			}
			
			return new Can();
		}
		
		final private static function ready():void
		{
			$thisDir = explode(DIRECTORY_SEPARATOR, __DIR__);
			
			array_pop($thisDir);
			
			defined('ENTRANCE')? : define('ENTRANCE', true);
			
			defined('ROOT')? : define('ROOT', implode(DIRECTORY_SEPARATOR, $thisDir));
			
			defined('DEBUG')? : define('DEBUG', true);
		}
	}
}