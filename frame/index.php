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

$obj = new \Extend\Object();

$obj->title = 'lfg';
echo $obj->title;

$obj->getUserInfo('100068');
\Extend\Object::getOpenId('111198');

echo $obj;

$obj('oox');
















//$db = new \Extend\Database();
//$db->where('uid >1')->order('uid desc')->limit(100);
