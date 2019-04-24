<?php
/**
 * 入口文件
 * User: lfg
 * Date: 19-4-24
 * Time: 下午5:26
 */

define('APP_PATH',__dir__.'/');
define('APP_DEBUG',true);

require(APP_PATH.'fashphp/Fashphp.php');

$config = require(APP_PATH.'config/config.php');

(new fashphp\Fashphp($config))->run();