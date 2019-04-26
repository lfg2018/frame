<?php
/**
 * 控制器基类
 * User: lfg
 * Date: 19-4-26
 * Time: 下午3:16
 */

namespace fastphp\base;

class Controller{
    protected $_controller;
    protected $_action;
    protected $_view;

    public function __construct($controller,$action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->view = new View($controller,$action);
    }

    public function assign($name,$value){
        $this->_view->assign($name,$value);
    }

    public function render(){
        $this->_view->render();
    }
}