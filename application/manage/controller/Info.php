<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/25
 * Time: 17:37
 */

namespace app\manage\controller;


use app\manage\helpers\Ref;
use app\common\model\InfoModel;
use app\manage\helpers\InfoHelpers;
use think\Db;
use think\facade\Request;

class Info extends Common
{

	protected $InfoModel;

	public function __construct() {
		parent::__construct();
		$this->InfoModel = new InfoModel();
	}

	public function index(){
		$where = [];
		$where['MenuId'] = input('get.id');
		$list = $this->InfoModel->where($where)->order('createTime desc')->paginate(15);
		$pages = $list->render();
		$list = $list->items();
		return $this->fetch('',['list'=>$list,'pages'=>$pages]);
	}

	public function addInfo(){
		if(Request::isPost()){
			$input = InfoHelpers::setAddInfoDefaultData();
			$result = $this->validate($input,'app\manage\validate\InfoValidate.add');
			if(true !== $result){
				// 验证失败 输出错误信息
				returnAjax(101,$result);
			}
			$result = $this->InfoModel->allowField(true)->data($input)->save();
			if(!$result) {
				returnAjax(101,Ref::CUE_SAVE_FAIL_INFO);
			}
			returnAjax(200,Ref::CUE_SAVE_SUCC_INFO,url('Info/index',['id'=>input('get.id')]));
		}
		return $this->fetch();
	}

	public function modifyInfo(){
		$id = input('param.id');
		$find = Db::name('info')->where(['MenuId'=>$id])->find();

		if(Request::isPost()){
			if(!$find) returnAjax(101,Ref::CUE_NOT_DATA);
			$input = InfoHelpers::setModifyInfoDefaultData();
			$result = $this->validate($input,'app\manage\validate\InfoValidate.modify');
			if(true !== $result){
				// 验证失败 输出错误信息
				returnAjax(101,$result);
			}
			$result = $this->InfoModel->allowField(true)->save($input,['infoId'=>$find['infoId']]);
			if(!$result) {
				returnAjax(101,Ref::CUE_SAVE_FAIL_INFO);
			}
			returnAjax(200,Ref::CUE_SAVE_SUCC_INFO,url('Info/index',['id'=>input('get.id')]));
		}
		if(!$find) abort(404,Ref::CUE_NOT_DATA);
		$find['selfPic'] 	= getDecodeJson($find['selfPic']);
		$find['initialPic'] = getDecodeJson($find['initialPic']);
		$find['specialPic'] = getDecodeJson($find['specialPic']);
		return $this->fetch('',['find'=>$find]);
	}


	public function removeInfo(){
		$id = input('post.id');
		$result = $this->InfoModel->where(['infoId'=>$id])->delete();
		if(!$result) returnAjax(101,Ref::CUE_DEL_FAIL_INFO);
		returnAjax(200,Ref::CUE_DEL_SUCC_INFO);
	}



}