<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/25
 * Time: 17:28
 */

namespace app\manage\validate;

use think\validate;
class InfoValidate extends validate
{

	protected $rule = [
		'title'			=>'require',
		'content'		=>'require',
	];

	protected $message = [
		'title.require'			=>'标题必须填写！',
		'content.require'		=>'内容必须填写！',
	];

	protected $scene = [
		'add'		=> ['title','content'],
		'modify'	=> ['title','content'],
	];
}