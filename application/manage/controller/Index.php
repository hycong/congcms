<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/6/29
 * Time: 15:34
 */

namespace app\manage\controller;

class Index extends Common
{

	public function index(){
		return $this->fetch();
	}


	public function welcome(){
		return $this->fetch();
	}

}