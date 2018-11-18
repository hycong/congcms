<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/5/29
 * Time: 17:10
 */
namespace app\manage\controller;

use app\manage\model\AuthRule;
use think\Controller;
use think\Db;
use think\facade\Request;

class Role extends Controller
{

	public function Rolenew(){
		if(Request::isPost()){
			$input = input('post.');
			if(count(explode('/',$input['url'])) < 3) {
				ajaxreturn(101,'URL错误，请确定URL正常！');
			}
			$AuthRule = new AuthRule();
			$AuthRule->allowField(true)->data($input)->save();
			ajaxreturn(200,'保存成功！');
		}

		$this->fetch();
	}

}