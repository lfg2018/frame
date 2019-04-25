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

namespace fastphp;

define('CORE_PATH') or define('CORE_PATH',__DIR__);

/**
 * 框架核心
 */

class Fastphp{
    protected $config = [];
    public function __construct($config){
        $this->config = $config;
    }

    /**
    类自动加载
    环境检查
    过滤敏感字符
    移除全局变量的老用法
    路由处理
     */
    public function run(){
        spl_autoload_register(array($this,'loadClass'));
        $this->setReporting();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
        $this->setDbConfig();
        $this->route();

    }

    //路由处理
    public function route(){
        $controllerName = $this->config['defaultController'];
        $actionName = $this->config['defaultAction'];
        $param = [];
        $url = $_SERVER['REQUEST_URI'];
        $position = strpos($url,'?');
        $url = $position === false ? $url : substr($url,'0',$position);

        $position = strpos($url,'index.php');
        if($position !== false){
            $url = substr($url,$position+strlen('index.php'));
        }
        $url = trim($url,'/');

        if($url){
            $urlArray = explode('/',$url);
            $urlArray = array_filter($urlArray);
            $controllerName = ucfirst($urlArray[0]);
            array_shift($urlArray);
            $actionName = $urlArray?$urlArray[0]:$actionName;
            array_shift($urlArray);
            $param = $urlArray?$urlArray:[];
        }
        //判断控制器是否存在
        $controller = 'app\\controllers\\'.$controllerName;
        if(!class_exists($controller)){
            exit($controller.'控制器不存在');
        }
        if(!method_exists($controller,$actionName)){
            exit($actionName.'方法不存在');
        }

        var_dump($param);
        var_dump($urlArray);exit;
    }

    //检查开发环境
    public function setReporting(){
        if(APP_DEBUG == true){
            error_reporting(E_ALL);
            ini_set('display_errors','On');
        }else{
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors','On');
        }
    }

    //删除敏感字符
    public function stripSlashesDeep($value){
        return is_array($value)?array_map(array($this,'stripslanshes',$value)):stripslashes($value);
    }

    // 检测敏感字符并删除
    public function removeMagicQuotes(){
        if(get_magic_quotes_gpc()){
            $_GET = isset($_GET)?$this->stripSlashesDeep($_GET):'';
            $_POST = isset($_GET)?$this->stripSlashesDeep($_POST):'';
            $_COOKIE = isset($_GET)?$this->stripSlashesDeep($_COOKIE):'';
            $_SESSION = isset($_GET)?$this->stripSlashesDeep($_SESSION):'';
        }
    }

    //自动加载
    public function loadClass($className){
        $classMap = $this->classMap();
        if(isset($classMap[$className])){
            $file = $classMap[$className];
        }elseif(strpos($className,'\\') !== false){
            $file = APP_PATH.str_replace('\\','/',$className).'.php';
            if(!is_file($file)){
                return;
            }
        }else{
            return;
        }
        include_once $file;

    }

    //内核文件命名空间映射关系
    protected function classMap(){
        return [
            'fastphp\base\Controller' => CORE_PATH.'/base/Controller.php',
            'fastphp\base\Model' => CORE_PATH.'/base/Model.php',
            'fastphp\base\View' => CORE_PATH.'/base/View.php',
            'fastphp\db\Db' => CORE_PATH.'/db/Db.php',
            'fastphp\db\Sql' => CORE_PATH.'/db/Sql.php',
        ];
    }

    // 检测自定义全局变量并移除。因为 register_globals 已经弃用，如果
    // 已经弃用的 register_globals 指令被设置为 on，那么局部变量也将
    // 在脚本的全局作用域中可用。 例如， $_POST['foo'] 也将以 $foo 的
    // 形式存在，这样写是不好的实现，会影响代码中的其他变量。 相关信息，
    // 参考:
    public function unregisterGlobals(){
        if(ini_get('register_globals')){
            $array = array('_SESSION','_POST','_GET','_COOKIE','_REQUEST','_ENV','_FILES');
            foreach($array as $value){
                foreach($GLOBALS[$value] as $key => $var){
                    if($var === $GLOBALS[$key]) unset($GLOBALS[$key]);
                }
            }
        }
    }

    //配置数据库信息
    public function setDbConfig(){
        if($this->config['db']){
            define('DB_HOST',$this->config['db']['host']);
            define('DB_NAME',$this->config['db']['dbname']);
            define('DB_USER',$this->config['db']['username']);
            define('DB_PASS',$this->config['db']['password']);
        }
    }


}
