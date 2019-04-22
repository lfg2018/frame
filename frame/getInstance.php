<?php
/**
 *  框架入口 
 * User: lfg
 * Date: 19-4-22
 * Time: 上午11:18
 */

define('BASEDIR',__DIR__);
include BASEDIR.'/Extend/Loader.php';
spl_autoload_register('\\Extend\\Loader::autoload');

$obj = Extend\SingleObject::getInstance();
$obj2 = Extend\SingleObject::getInstance();

var_dump($obj,$obj2);
