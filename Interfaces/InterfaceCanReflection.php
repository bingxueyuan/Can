<?php
/**
 * @author : YuanZhiHeng
 * @since  : 1.0.0.0
 * @version: 1.0.0.0
 * @license: MIT
 * @date   : 2018/9/30
 */

namespace Can\Interfaces {
	
	
	defined('ENTRANCE')? : exit();
	
	interface InterfaceCanReflection
	{
		public function getObjectFileMd5(string $key):string;
		public function getObjectFile(string $key):string;
	}
}