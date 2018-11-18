<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/25
 * Time: 11:50
 */

namespace app\manage\controller;


use app\manage\helpers\Ref;
use app\common\model\PageModel;
use app\manage\helpers\PageHelpers;
use think\App;
use think\facade\Request;

class Page extends Column
{

	protected $ColumnModel;
	protected $PageModel;

	public function __construct(App $app = null) {
		parent::__construct($app);
		$this->PageModel = new PageModel();
	}

	public function index()
	{
		$where = [];
		$list = $this->PageModel->where($where)->order('createTime desc')->paginate(15);
		$pages = $list->render();
		$list = $list->items();
		return $this->fetch('',['list'=>$list,'pages'=>$pages]);
	}

	public function addPage(){
		if(Request::isPost()){
			$input = PageHelpers::setAddPageDefaultData();
			$result = $this->validate($input,'app\manage\validate\PageValidate.add');
			if(true !== $result){
				// 验证失败 输出错误信息
				returnAjax(101,$result);
			}
			$result = $this->PageModel->allowField(true)->data($input)->save();
			if(!$result) returnAjax(101,Ref::CUE_SAVE_FAIL_INFO);
			returnAjax(200,Ref::CUE_SAVE_SUCC_INFO);
		}
		return $this->fetch();
	}


	/**
	 * 单页面修改
	 * @return mixed
	 */
	public function modifyPage(){
		$id = input('param.id');
		$find = $this->PageModel->where(['PageId'=>$id])->find();
		if(Request::isPost()){
			if(!$find) returnAjax(101,Ref::CUE_NOT_DATA);
			$input = PageHelpers::setModifyPageDefaultData();
			$result = $this->validate($input,'app\manage\validate\PageValidate.modify');
			if(true !== $result){
				// 验证失败 输出错误信息
				returnAjax(101,$result);
			}
			$result = $this->PageModel->allowField(true)->save($input,['PageId'=>$find['PageId']]);
			if(!$result) returnAjax(101,Ref::CUE_UPDATE_FAIL_INFO);
			returnAjax(200,Ref::CUE_UPDATE_SUCC_INFO);
		}
		if(!$find) abort(404,Ref::CUE_NOT_DATA);
		return $this->fetch();
	}


	/**
	 * 删除单页
	 */
	public function removePage(){
		$id = input('post.id');
		$result = $this->PageModel->where(['PageId'=>$id])->delete();
		if(!$result) returnAjax(101,Ref::CUE_DEL_FAIL_INFO);
		returnAjax(200,Ref::CUE_DEL_SUCC_INFO);
	}


}