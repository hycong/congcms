<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/25
 * Time: 17:59
 */

namespace app\manage\controller;


use app\manage\helpers\Ref;
use app\manage\model\CategoryModel;
use helpers\CategoryHelpers;
use think\Db;
use think\facade\Request;

class Category extends Common
{
	protected $CategoryModel;


	public function __construct() {
		parent::__construct();
		$this->CategoryModel = new CategoryModel();
	}

	public function index(){
		$where = [];
		$where['MenuId'] = input('get.Menuid',0);
		$list = $this->CategoryModel->where($where)->order('createTime desc')->paginate(15);
		$pages = $list->render();
		$list = $list->items();
		return $this->fetch('',['list'=>$list,'pages'=>$pages]);
	}

	/**
	 * 添加分类
	 * @return mixed
	 */
	public function addCategory(){
		$MenuId = input('get.MenuId');
		if(Request::isPost()){
			$input = CategoryHelpers::setAddCategoryDefaultData();
			$result = $this->validate($input,'app\manage\validate\CategoryValidate.add');
			if(true !== $result){
				// 验证失败 输出错误信息
				returnAjax(101,$result);
			}
			$CategoryModel = new CategoryModel();
			$result = $CategoryModel->allowField(true)->data($input)->save();
			if(!$result) {
				returnAjax(101,Ref::CUE_SAVE_FAIL_INFO);
			}
			returnAjax(200,Ref::CUE_SAVE_SUCC_INFO,url('Category/index'));
		}
		$catelist = CategoryHelpers::getCategoryList();
		$this->assign('catelist',$catelist);
		return $this->fetch();
	}

	/**
	 *	修改分类
	 * @return mixed
	 */
	public function modifyCategory(){
		$id = input('param.id');
		$find = $this->CategoryModel->where(['cateId'=>$id])->find();

		if(Request::isPost()){
			if(!$find) returnAjax(101,Ref::CUE_NOT_DATA);
			$input = CategoryHelpers::setModifyCategoryDefaultData();
			$result = $this->validate($input,'app\manage\validate\CategoryValidate.modify');
			if(true !== $result){
				// 验证失败 输出错误信息
				returnAjax(101,$result);
			}
			$result = $this->CategoryModel->allowField(true)->save($input,['cateId'=>$find['cateId']]);
			if(!$result) {
				returnAjax(101,Ref::CUE_SAVE_FAIL_INFO);
			}
			returnAjax(200,Ref::CUE_SAVE_SUCC_INFO,url('Category/index'));
		}
		if(!$find) abort(404,Ref::CUE_NOT_DATA);
		$find['initialPic'] = getDecodeJson($find['initialPic']);
		$find['specialPic'] = getDecodeJson($find['specialPic']);
		$find['imgUrl'] 	= getDecodeJson($find['imgUrl']);
		$catelist = CategoryHelpers::getCategoryList();
		$this->assign('catelist',$catelist);
		return $this->fetch('',['find'=>$find]);
	}

	public function removeCategory(){
		$id = input('get.id');
		$result = Db::name('column')->where(['cateId'=>$id])->delete();
		if(!$result) returnAjax(101,Ref::CUE_DEL_FAIL_INFO);
		returnAjax(200,Ref::CUE_DEL_SUCC_INFO);
	}

}