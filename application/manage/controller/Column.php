<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/22
 * Time: 10:01
 */

namespace app\manage\controller;


use app\manage\helpers\Ref;
use app\common\model\ColumnModel;
use app\manage\helpers\ColumnHelpers;
use app\manage\helpers\PageHelpers;
use think\App;
use think\Controller;
use think\Db;
use think\facade\Request;
use tree\Tree;

class Column extends Common
{
	protected $ColumnModel;

	public function __construct(App $app = null) {
		parent::__construct($app);
		$this->ColumnModel = new ColumnModel();
	}

	public function index(){
		$where = [];
		$list = Db::name('column')->where($where)->order('createTime desc')->paginate(1,false);
		$pages = $list->render();
		$list = $list->items();
		return $this->fetch('',['list'=>$list,'pages'=>$pages]);
	}

	/**
	 * 添加菜单
	 * @return mixed
	 */
	public function addColumn(){
		if(Request::isPost()){
			$input = ColumnHelpers::setAddColumnDefaultData();
			$result = $this->validate($input,'app\manage\validate\ColumnValidate.add');
			if(true !== $result){
				// 验证失败 输出错误信息
				returnAjax(101,$result);
			}
			$result = $this->ColumnModel->allowField(true)->data($input)->save();
			if(!$result) {
				returnAjax(101,Ref::CUE_SAVE_FAIL_INFO);
			}
			if($input['colType']==1) PageHelpers::createPage($this->ColumnModel->id,$input['title']);
			returnAjax(200,Ref::CUE_SAVE_SUCC_INFO,url('Column/index'));
		}
		$columnlist = ColumnHelpers::getColumnList();
		return $this->fetch('',['columnlist'=>$columnlist]);
	}

	/**
	 *	修改菜单
	 * @return mixed
	 */
	public function modifyColumn(){
		$id = input('param.id');
		$find = $this->ColumnModel->where(['MenuId'=>$id])->find();

		if(Request::isPost()){
			if(!$find) returnAjax(101,Ref::CUE_NOT_DATA);
			$input = ColumnHelpers::setModifyColumnDefaultData();
			$result = $this->validate($input,'app\manage\validate\ColumnValidate.modify');
			if(true !== $result){
				// 验证失败 输出错误信息
				returnAjax(101,$result);
			}
			$result = $this->ColumnModel->allowField(true)->save($input,['MenuId'=>$find['MenuId']]);
			if(!$result) {
				returnAjax(101,Ref::CUE_SAVE_FAIL_INFO);
			}
			if($input['colType']==1) PageHelpers::createPage($input['menuId'],$input['title']);
			returnAjax(200,Ref::CUE_SAVE_SUCC_INFO,url('Column/index'));
		}
		if(!$find) abort(404,Ref::CUE_NOT_DATA);
		$find['initialPic'] = getDecodeJson($find['initialPic']);
		$find['specialPic'] = getDecodeJson($find['specialPic']);
		$find['imgUrl'] 	= getDecodeJson($find['imgUrl']);
		$columnlist = &ColumnHelpers::getColumnList();
		return $this->fetch('',['find'=>$find,'columnlist'=>$columnlist]);
	}


	public function removeColumn(){
		$id = input('get.id');
		$result = $this->ColumnModel->where(['MenuId'=>$id])->delete();
		if(!$result) returnAjax(101,Ref::CUE_DEL_FAIL_INFO);
		returnAjax(200,Ref::CUE_DEL_SUCC_INFO);
	}



}