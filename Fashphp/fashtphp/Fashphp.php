<?php
/**
 * 核心框架类
 * User: lfg
 * Date: 19-4-24
 * Time: 下午5:35
入口文件对框架类做了两步操作：实例化，调用run()方法。
实例化操作接受$config参数配置，并保存到对象属性中。
run()方法则调用用类自身方法，完成下面几个操作：
类自动加载
环境检查
过滤敏感字符
移除全局变量的老用法
路由处理
 */

namespace fashphp;

define('CORE_PATH') or define('CORE_PATH',__DIR__);

