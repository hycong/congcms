<?php
/**
 * Created by PhpStorm.
 * User: hyc
 * Date: 2018/9/20
 * Time: 20:26
 */

namespace app\manage\controller;


use app\manage\helpers\Ref;
use app\manage\model\AuthGroup;
use app\manage\model\AuthRule;
use think\facade\Request;

class Auth extends Common
{

    public function authRule(){
        $where = [];
        $AuthRule = new AuthRule();
        $list = $AuthRule->where($where)->order('id desc')->paginate(15,false);
        $pages = $list->render();
        $list = $list->items();
        return $this->fetch('',['pages'=>$pages,'list'=>$list]);
    }


    public function addRule(){
        if(Request::isPost()){
            $input = input('post.');
            $result = $this->validate($input,'app\manage\validate\AuthValidate.add');
            if(true !== $result) returnAjax(101,$result);
            $AuthRule = new AuthRule();
            if($AuthRule->where(['title'=>$input['title']])->value('id')) returnAjax(101,'该节点已存在！');
            $AuthRule->allowField(true)->data($input)->save();
            $handle = $AuthRule->id;
            if($handle) returnAjax(101,Ref::CUE_SAVE_SUCC_INFO);
            returnAjax(100,Ref::CUE_SAVE_FAIL_INFO);
        }
        return $this->fetch('rule_add');
    }

    public function modifyRule(){
        $id = input('id');
        $input = input('post.');
        $AuthRule = new AuthRule();
        $find = $AuthRule->where(['id'=>$id])->find();
        if(Request::isPost()){
            if(!$find) returnAjax(101,Ref::CUE_NOT_DATA);
            $result = $this->validate($input,'app\manage\validate\AuthValidate.modify');
            if(true !== $result) returnAjax(101,$result);
            $AuthRule->allowField(true)->save($input,['id'=>$input['id']]);
            $handle = $AuthRule->id;
            if($handle) returnAjax(101,Ref::CUE_SAVE_SUCC_INFO);
            returnAjax(100,Ref::CUE_SAVE_FAIL_INFO);
        }
        if(!$find) $this->error(Ref::CUE_NOT_DATA);
        return $this->fetch('rule_modify',['find'=>$find]);
    }



    public function authGroup(){
        $where = [];
        $AuthGroup = new AuthGroup();
        $list = $AuthGroup->where($where)->order('id desc')->paginate(15,false);
        $pages = $list->render();
        $list = $list->items();
        return $this->fetch('auth_group',['pages'=>$pages,'list'=>$list]);
    }


}