<?php
/**
 * 入口文件
 * User: lfg
 * Date: 19-4-24
 * Time: 下午5:26
 */
define('APP_PATH',__dir__.'/');
define('APP_DEBUG',true);
require(APP_PATH.'fastphp/Fastphp.php');
$config = require(APP_PATH.'config/config.php');

(new fastphp\Fastphp($config))->run();