# Can
include_once 'CanLoad.class.php';

// 载入Can容器
$can = \Can\CanLoad::autoload();

var_dump($can);

---
对象方法：
--
public function add(string $key, string $value, bool $lazyLoad = true, ...$parameter):void;

public function get(string $key);

public function set(string $key, string $value, bool $lazyLoad = true, ...$parameters):void;

public function del(string $key):void;

public function exists(string $key):bool;

public function getKeys():array;

public function getObjectHash(string $key):string;

public function isLazyLoad(string $key):bool;

public function getObjectFileMd5(string $key):string;
		
public function getObjectFile(string $key):string;

#关于版本
这是早期版本，新版本支持SOAP远程对象发现协议
早期版本（这个版本）是意见征求版本，想要添加新的功能、好的意见可以告诉我
QQ：1510412641
--
测试发现，能装10000个对象，而且不崩溃