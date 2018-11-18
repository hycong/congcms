<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/7/13
 * Time: 10:53
 */

namespace app\manage\controller;


use app\manage\model\RegionModel;
use think\App;

class Region extends Column
{

	protected $RegionModel;

	public function __construct(App $app = null) {
		parent::__construct($app);
		$this->RegionModel = new RegionModel();
	}

	/**
	 * 获取一级省份
	 */
	public function getProvinceList(){
		$list = $this->RegionModel->where(['level'=>1])->field('region_id,region_name')->select();
		returnAjax(100,$list);
	}


	/**
	 * 获取二级城市
	 */
	public function getCityList(){
		$city_id = input('city_id');
		$list = $this->RegionModel->where([
			'level'=>2,
			'parent_id'=>$city_id,
		])->field('region_id,region_name')->select();
		if(!$list) returnAjax(101,'没有找到城市！');
		returnAjax(100,$list);
	}


	/**
	 * 获取三级区域
	 */
	public function getSubRegionList(){
		$region_id = input('region_id');
		$list = $this->RegionModel->where([
			'level'=>2,
			'parent_id'=>$region_id,
		])->field('region_id,region_name')->select();
		if(!$list) returnAjax(101,'没有找到城市！');
		returnAjax(100,$list);
	}

}