<?php
/**
 * @author : YuanZhiHeng
 * @since  : 1.0.0.0
 * @version: 1.0.0.0
 * @license: MIT
 * @date   : 2018/9/26
 */

namespace Can\Interfaces {
	
	
	defined('ENTRANCE')? : exit();
	
	interface InterfaceCan
	{
		public function add(string $key, string $value, bool $lazyLoad = true, ...$parameter):void;
		public function get(string $key);
		public function set(string $key, string $value, bool $lazyLoad = true, ...$parameters):void;
		public function del(string $key):void;
		public function exists(string $key):bool;
		public function getKeys():array;
		public function getObjectHash(string $key):string;
		public function isLazyLoad(string $key):bool;
	}
}