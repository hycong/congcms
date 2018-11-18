<?php
/**
 * Created by PhpStorm.
 * User: hyc
 * Date: 2018/9/21
 * Time: 21:15
 */

namespace app\manage\validate;


use think\Validate;

class AuthValidate extends Validate
{

    protected $rule = [
        'title' => 'require',
        'name' => 'require',
        'status' => 'require',
    ];

    protected $message = [
        'title.require' => '请输入节点名！',
        'name.require' => '请输入节点地址！',
        'status.require' => '请选择状态！',
    ];

    protected $scene = [
        'add'           =>  ['title','name','status'],
        'modify'        =>  ['title','name','status'],
    ];

}