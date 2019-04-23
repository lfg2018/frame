<?php
namespace Extend;

class Loader
{
	static function autoload($class){		  
		$dirStr = BASEDIR.'/'.str_replace('\\','/',$class).'.php';
		echo 'autoload dir=='. $dirStr.'/n';
		require $dirStr;
	}
}
