<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/5/29
 * Time: 17:17
 */

namespace app\manage\controller;


use think\Controller;
use think\facade\Request;

class Common extends Controller
{

	public function __construct() {
        parent::__construct();
//        if(!session('roleId')) {
//            $this->redirect(url('Login/index'));
//        }
//        p($_SESSION);
//		if(role(Request::module().'/'.Request::controller().'.'.Request::action())===false) {
//			ajaxreturn(101,'没有此操作权限！');
//		}
	}

	public function login(){
		//session
		$goruplist = Db::name('auth_group_access')->where(['uid'=>session('userid')])->column('group_id');
		session('roleId',implode('_',sort($goruplist)));
	}


	public function get_nav(){
//        if(!cache('memu_',session('roleId'))){
//            $memu = cache('memu_'.session('roleId'));
//        }else{
            $memu = createMenu();// 生成菜单
//        }
//        p($memu);
        echo json_encode($memu);
        exit();
    }

}