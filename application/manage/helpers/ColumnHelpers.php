<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/22
 * Time: 17:11
 */
namespace app\manage\helpers;
use think\Db;
use tree\Tree;

class ColumnHelpers
{

	/**
	 * 生成菜单缓存
	 */
	public static function createColumnCache(){
		$data = Db::name('column')->where(['enabled'=>1])->order('sort desc,createTime desc')->select();
		$data = array_column($data,'MenuId',null);
		foreach ($data as $key => $value){
			$data[$key]['initialPic'] 	= getDecodeJson($value['initialPic']);
			$data[$key]['specialPic'] 	= getDecodeJson($value['specialPic']);
			$data[$key]['imgUrl'] 		= getDecodeJson($value['imgUrl']);
		}
		cache('MenuList',$data);
	}


	/**
	 * 更新指定Id菜单，不更新排序
	 * @param $id
	 * @return bool
	 */
	public static function modifyColumnCache($id){
		$MenuList = cache('MenuList');
		if(!$MenuList){
			self::createColumnCache();
			return true;
		}
		$data = Db::name('column')->where(['id'=>$id])->select();
		$data['initialPic'] = getDecodeJson($data['initialPic']);
		$data['specialPic'] = getDecodeJson($data['specialPic']);
		$data['imgUrl'] 	= getDecodeJson($data['imgUrl']);
		$MenuList[$data['MenuId']] = $data;
		cache('MenuList',$data);
	}

	/**
	 * 接收与设置默认值
	 * @return mixed
	 */
	public static function setAddColumnDefaultData(){
		$input = input('post.');
		$input['initialPic'] 	= getFieldJson('initialPic');
		$input['specialPic'] 	= getFieldJson('specialPic');
		$input['imgUrl'] 		= getReplaceJson('imgUrl');
		$input['createTime']	= time();
		$input['createAdminId'] = session('userid');
		$input['modifyTime'] 	= time();
		$input['modifyAdminId'] = session('userid');
		return $input;
	}

	/**
	 * 接收与设置默认值
	 * @return mixed
	 */
	public static function setModifyColumnDefaultData(){
		$input = input('post.');
		$input['initialPic'] 	= getFieldJson($input['initialPic']);
		$input['specialPic'] 	= getFieldJson($input['specialPic']);
		$input['imgUrl'] 		= getReplaceJson($input['imgUrl']);
		$input['modifyTime']	= time();
		$input['modifyAdminId'] = session('userid');
		return $input;
	}


	public static function getColumnList($isTree = true){
		$columnlist = Db::name('column')
			->where(['enabled'=>1])
			->field('menuId,title,parentId')
			->order('sort desc,createTime desc')
			->select();
		if($isTree) $columnlist = Tree::tree($columnlist,0,'menuId','parentId');
		return $columnlist;
	}

}