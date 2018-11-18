<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/27
 * Time: 16:08
 */

namespace helpers;


use think\Db;

class CategoryHelpers
{

	public static function setAddCategoryDefaultData(){
		$input = input('post.');
		$input['createTime']	= time();
		$input['createAdminId'] = session('userid');
		$input['modifyTime'] 	= time();
		$input['modifyAdminId'] = session('userid');
		$input['cateImgUrl'] = getReplaceJson($input['cateImgUrl']);
		return $input;
	}

	public static function setModifyCategoryDefaultData(){
		$input = input('post.');
		$input['modifyTime'] 	= time();
		$input['modifyAdminId'] = session('userid');
		$input['cateImgUrl'] = getReplaceJson($input['cateImgUrl']);
		return true;
	}



	public static function getCategoryList($MenuId = 0,$TreeType = true,$field = 'cateId,cateName,cateFtitleName'){
		$data = Db::name('category')->where(['MenuId'=>$MenuId])->field($field)->order('createTime desc,cateId desc')->select();
		if($TreeType){
			$data = Tree::tree($data,0,'parentId');
		}
		return $data;
	}

}