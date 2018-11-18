<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/25
 * Time: 15:22
 */

namespace app\manage\validate;
use think\validate;

class ColumnValidate extends validate
{

	protected $rule = [
		'title' 		=> 'require',
		'url' 			=> 'require',
		'pageNum' 		=> 'require|number',
		'detailName' 	=> 'require',
		'initialPic' 	=> 'require',
		'specialPic' 	=> 'require',
	];

	protected $message = [
		'title.require' 		=> '标题必须填写！',
		'url.require' 			=> '地址必须填写！',
		'pageNum.require' 		=> '每页条数必须设置！',
		'pageNum.number' 		=> '每页条数必须是数字！',
		'detailName.require' 	=> '详情页面必须选择！',
		'initialPic.require' 	=> '列表页图片尺寸必须填写！',
		'specialPic.require' 	=> '特殊推广图片尺寸必须填写！',
	];

	protected $scene = [
		'add' 		=> ['title','url','pageNum','pageName','detailName','initialPic','specialPic'],
		'modify' 	=> ['title','url','pageNum','pageName','detailName','initialPic','specialPic'],
	];

}