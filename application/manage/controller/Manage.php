<?php
/**
 * Created by PhpStorm.
 * User: hyc
 * Date: 2018/9/16
 * Time: 15:21
 */

namespace app\manage\controller;

use app\common\model\AdminModel;
use app\manage\helpers\Ref;
use think\Db;
use think\facade\Request;

/**
 * 管理员类
 * Class Manage
 * @package app\manage\controller
 */
class Manage extends Common
{

    public function __construct()
    {
        parent::__construct();
    }


    public function userList(){
        $where = [];
        $AdminModel = new AdminModel();
        $where['uid'] = ['neq',1];
        $list = $AdminModel->where($where)->order('uid desc')->paginate(15,false);
        $pages = $list->render();
        $list = $list->items();
        return $this->fetch('',['pages'=>$pages,'list'=>$list]);
    }


    public function addAdmin(){
        if(Request::isPost()){
            $input = input('post.');
            $AdminModel = new AdminModel();
            $input['createTime'] = time();
            $AdminModel->allowField(true)->data($input)->insert();
            $handle = $AdminModel->id;
            if($handle) returnAjax(101,Ref::CUE_SAVE_SUCC_INFO);
            returnAjax(100,Ref::CUE_SAVE_FAIL_INFO);
        }
//        $rolelist = new Ref().
        return $this->fetch('admin_add');
    }

    public function modifyAdmin(){
        $input = input('post.');
        $AdminModel = new AdminModel();
        $find = $AdminModel->where(['userid'=>$input['userid']])->find();
        if(Request::isPost()){
            if(!$find) returnAjax(101,Ref::CUE_NOT_DATA);
            $AdminModel->allowField(true)->save($input,['userid'=>$input['userid']]);
            $handle = $AdminModel->id;
            if($handle) returnAjax(101,Ref::CUE_SAVE_SUCC_INFO);
            returnAjax(100,Ref::CUE_SAVE_FAIL_INFO);
        }
        if(!$find) $this->error(Ref::CUE_NOT_DATA);
        return $this->fetch();
    }


}