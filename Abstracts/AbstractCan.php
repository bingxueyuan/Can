<?php
/**
 * @author : YuanZhiHeng
 * @since  : 1.0.0.0
 * @version: 1.0.0.0
 * @license: MIT
 * @date   : 2018/9/26
 */

namespace Can\Abstracts {
	
	
	defined('ENTRANCE')? : exit();
	
	abstract class AbstractCan extends \ArrayIterator
	{
		public $fileLoadedSuccess = array();
		
		public function __construct()
		{
			spl_autoload_register('self::autoLoadFunction');
		}
		
		public function register(string $name, bool $lazyLoad = true, $parameters = array())
		{
			$reflectionClass = $this->getReflection($name, true);
			
			list($className) = array_reverse(explode('\\', $name));
			
			if (!$reflectionClass->isInstantiable())
			{
				echo "不能实例化：" . $className;
			}
			
			$constructor = $reflectionClass->getConstructor();
			
			if ($constructor === null)
			{
				return $lazyLoad === true? function () use ($name)
				{
					return new $name;
				}
					: new $name;
			}
			else
			{
				$countConstructorParameters = count($reflectionClass->getConstructor()->getParameters());
				
				if (count($parameters) < $countConstructorParameters)
				{
					echo "构造函数参数不够：" . $className;
				}
				
				$parameter = array_slice($parameters, 0);
				
				return $lazyLoad === true? function () use ($reflectionClass, $parameter)
				{
					return $reflectionClass->newInstanceArgs($parameter);
				}
					: $reflectionClass->newInstanceArgs($parameter);
			}
		}
		
		protected function getReflection(string $mixed, bool $className = true)
		{
			if ($className === true)
			{
				$class = $mixed;
			}
			else
			{
				if ($this->offsetExists($mixed))
				{
					$value = $this->offsetGet($mixed);
					
					$class = $value instanceof \Closure? $value() : $value;
				}
				else
				{
					return null;
				}
			}
			
			try
			{
				return new \ReflectionClass($class);
			}
			catch (\Throwable $exception)
			{
				exit();
			}
			
		}
		
		protected function autoLoadFunction(string $class):void
		{
			$classNameToArray = explode(DIRECTORY_SEPARATOR, $class);
			
			list($className) = array_reverse($classNameToArray);
			
			array_pop($classNameToArray);
			
			$namespace = implode(DIRECTORY_SEPARATOR, $classNameToArray);
			
			empty($namespace)? $namespace = null : $namespace = $namespace . DIRECTORY_SEPARATOR;
			
			(preg_match('/(Trait)/', $class) === 1
				|| preg_match('/(Abstract)/', $class) === 1
				|| preg_match('/(Interface)/', $class) === 1) ?
				$file = $className . '.' : $file = $className . '.class.';
			
			$pathExtension = pathinfo(__FILE__, PATHINFO_EXTENSION);
			
			$fullFile = ROOT . DIRECTORY_SEPARATOR . $namespace . $file . $pathExtension;
			
			if (!in_array($fullFile, $this->fileLoadedSuccess))
			{
				if (file_exists($fullFile))
				{
					require_once $fullFile;
					
					array_push($this->fileLoadedSuccess, $fullFile);
					
					echo "已加载：" . $fullFile;
				}
				else
				{
					echo "未加载：" . $fullFile;
				}
			}
		}
	}
}