<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/25
 * Time: 13:56
 */
namespace app\manage\validate;

use think\validate;

class PageValidate extends validate
{

	protected $rule = [
		'title' => 'require',
		'description' => 'require',
		'content' => 'require',
	];

	protected $message = [
		'title.require' => '标题必须填写！',
	];

	protected $scene = [
		'add'  =>  ['title'],
		'modify'  =>  ['title'],
	];

}