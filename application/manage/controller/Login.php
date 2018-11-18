<?php
/**
 * Created by PhpStorm.
 * User: hyc
 * Date: 2018/8/24
 * Time: 19:06
 */
namespace app\manage\controller;
use think\Controller;
class Login extends Controller {

    public function __construct(\think\App $app = null)
    {
        parent::__construct($app);
    }

    public function index(){

        return $this->fetch();
    }

    public function goLogin(){

    }

}