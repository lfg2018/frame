<?php
namespace Extend;

class Object{
	protected $array = array();

	function __set($name,$value){
		echo 'this is __set func';
	}

	function __get($name){
		echo "this is __get func";
	}

	function __call($name,$arguments){
		var_dump($name,$arguments);
	}

	function __callStatic($name,$arguments){
		var_dump($name,$arguments);
	}

	function __toString(){
		echo 'this is __toString func';
		return 'toString:'.$this->name.'\n';
	}

	function __invoke($param){
		echo $param."<br>this is __invoke func";
	}
}
