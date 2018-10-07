<?php
/**
 * @author : YuanZhiHeng
 * @since  : 1.0.0.0
 * @version: 1.0.0.0
 * @license: MIT
 * @date   : 2018/9/26
 */

namespace Can {
	
	
	defined('ENTRANCE')? : exit();
	
	final class Can extends Abstracts\AbstractCan implements Interfaces\InterfaceCan, Interfaces\InterfaceCanReflection
	{
		final public function __construct()
		{
			parent::__construct();
		}
		
		final public function add(string $key, string $value, bool $lazyLoad = true, ...$parameter):void
		{
			$this->offsetExists($key)? null : $this[$key] = $this -> register($value, $lazyLoad, $parameter);
		}
		
		final public function get(string $key)
		{
			if ($this->offsetExists($key))
			{
				$value = $this->offsetGet($key);
				
				return $value instanceof \Closure? $value() : $value;
			}
			else
			{
				return null;
			}
		}
		
		final public function set(string $key, string $value, bool $lazyLoad = true, ...$parameters):void
		{
			$this->offsetExists($key)? $this[$key] = $this->register($value, $lazyLoad, $parameters) : null;
		}
		
		final public function del(string $key):void
		{
			$this->offsetExists($key)? $this->offsetUnset($key) : null;
		}
		
		final public function exists(string $key):bool
		{
			return $this->offsetExists($key);
		}
		
		final public function getKeys():array
		{
			$keys[] = null;
			$this->rewind();
			
			while ($this->valid())
			{
				$keys[] = $this->key();
				$this->next();
			}
			
			return $keys;
		}
		
		final public function getObjectHash(string $key):string
		{
			return $this->offsetExists($key)? spl_object_hash($this[$key] instanceof \Closure? $this[$key]() : $this[$key]) : '';
		}
		
		final public function getObjectFileMd5(string $key):string
		{
			return md5($this->getObjectFile($key));
		}
		
		final public function getObjectFile(string $key):string
		{
			return $this->getReflection($key, false) -> getFileName();
		}
		
		final public function isLazyLoad(string $key):bool
		{
			return $this->offsetExists($key)? $this->offsetGet($key) instanceof \Closure? true : false : null;
		}
	}
}