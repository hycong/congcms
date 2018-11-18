<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/27
 * Time: 11:53
 */

namespace app\manage\helpers;


class InfoHelpers
{

	public static function setAddInfoDefaultData(){
		$input = input('post.');
		$input['createTime']	= time();
		$input['createAdminId'] = session('userid');
		$input['modifyTime'] = time();
		$input['modifyAdminId'] = session('userid');
		return $input;
	}


	public static function setModifyInfoDefaultData(){
		$input = input('post.');
		$input['selfPic'] 		= getReplaceJson($input['selfPic']);
		$input['initialPic'] 	= getFieldJson($input['initialPic']);
		$input['specialPic'] 	= getFieldJson($input['specialPic']);
		$input['createTime']	= time();
		$input['createAdminId'] = session('userid');
		$input['modifyTime'] 	= time();
		$input['modifyAdminId'] = session('userid');
		return $input;
	}

}