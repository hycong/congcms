<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/25
 * Time: 11:16
 */

namespace app\manage\helpers;


use app\common\model\PageModel;
use think\Db;

class PageHelpers
{

	private static $PageModel;

	public function __construct() {
		self::$PageModel = new PageModel();
	}

	/**
	 * 菜单创建单页与绑定关系
	 * @param $MenuId
	 * @param $MenuName
	 * @return bool
	 */
	public static function createPage($MenuId,$MenuName){
		if(self::$PageModel->where(['MenuId'=>$MenuId])->find()) return true;
		$saveData = [
			'MenuId'		=> $MenuId,
			'title'			=> $MenuName,
			'createTime'	=> time(),
			'createAdminId'	=> session('userid'),
			'modifyTime'	=> time(),
			'modifyAdminId'	=> session('userid'),
			'content'		=> $MenuName
		];
		$result = Db::name('page')->insertGetId($saveData);
		if(!$result) return false;
		return true;
	}

	/**
	 * 接收与设置默认值
	 * @return mixed
	 */
	public static function setAddPageDefaultData(){
		$input = input('post.');
		$input['createTime']	= time();
		$input['createAdminId'] = session('userid');
		$input['modifyTime'] = time();
		$input['modifyAdminId'] = session('userid');
		return $input;
	}

	/**
	 * 接收与设置默认值
	 * @return mixed
	 */
	public static function setModifyPageDefaultData(){
		$input = input('post.');
		$input['modifyTime'] = time();
		$input['modifyAdminId'] = session('userid');
		return $input;
	}

}