<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function p($row = [],$isExit = true){
    echo '<pre>'.print_r($row,true).'</pre>';
    if ($isExit) exit();
}



/**
 * 检查权限
 * @param name string  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
 * @param uid  int           认证用户的id
 * @param string mode        执行check的模式
 * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
 * @return boolean           通过验证返回true;失败返回false
 */
function role($name, $uid = '', $type=1, $mode='url', $relation='or'){
    if(!$name) return false;
    if(!$uid) $uid = session('userid');
    //无需验证的操作
    $uneed_check_array = config('Auth_UNEED_CHECK_ARRAY');
    if(in_array($name,$uneed_check_array) || session('isAdmin') == '1'){
        //后台首页控制器无需验证,超级管理员无需验证
        return true;
    }
    $Auth = new \think\Auth();
    if($Auth->check($name,$uid,$type,$mode,$relation)!== false) return true;
    return false;
}

/**
 * 生成菜单存入缓存
 * @return array
 */
function createMenu(){
//	$goruplist = Db::name('auth_group_access')->where(['uid'=>session('userid')])->column('group_id');
//	$ruleslist = Db::name('auth_rule')->where(['id'=>['in',$goruplist]])->column('rules');
//	$ruleslist = implode(',',$ruleslist);
//	$ruleslist = array_unique(explode(',',$ruleslist));
//	$memu = Db::name('auth_rule')->where(['id'=>['in',$ruleslist],'ismenu'=>1,'status'=>1])->field('id,pid,name,condition');
//	$memu = tree\Tree::tree($memu);
//	cache('memu_'.implode('_',sort($goruplist)),$memu);
    $memu = [
        'data' => [
            [
                "text" => "栏目管理",
                "icon" => "&#xe620;",
                "subset" => [
                    ["text" => "栏目列表","icon" => "&#xe621;","href" => url('Column/index')],
                ]
            ],
            [
                "text" => "管理员管理",
                "icon" => "&#xe628;",
                "subset" => [
                    ["text" => "角色管理","icon" => "&#xe621;","href" => url('Auth/authGroup')],
                    ["text" => "权限管理","icon" => "&#xe621;","href" => url('Auth/authRule')],
                    ["text" => "管理员列表","icon" => "&#xe621;","href" => url('Manage/userList')],
                ]
            ],
        ],
    ];
    return $memu;
}


function returnAjax($code=101,$msg='',$data = [],$url='',$isExit = true){
    $data = [
        'code' => $code,
        'msg'  => $msg,
        'data' => $data,
        'url' => $url,
    ];
    if($isExit) {
        exit(json_encode($data));
    }else{
        echo json_encode($data);
    }
}

/**
 * 接收指定的字段转换为 json
 * @param string $field 转换的字段名
 * @param string $type  接收的类型(get、post、param?)
 * @return string
 */
function getFieldJson($field,$type = 'post'){
    if(!isset($field) || empty($field)) return '';
    if(input($type.'.'.$field) === false) return '';
    return json_encode(input($type.'.'.$field));
}

/**
 * 图片、附件类型转json
 * @param        $field			转换的字段名
 * @param string $urlPrefix		Url前缀
 * @param int    $type			0 未定义类型只有url ； 1 只有url ； 2  有name、url
 * @param string $method		接收的类型(get、post、param?)
 * @return string
 */
function getReplaceJson($field,$urlPrefix='',$type=0,$method='post'){
    $data = input($method.'.'.$field);
    if(!isset($field) || empty($field)) return '';
    $json = '';
    if(!$data) return $json;
    foreach ($data as $key => $value){
        if($type == 1) {
            foreach ($data as $key => $value){
                if(!$value) continue;
                $json[]['url'] = $urlPrefix.'/'.$value;
            }
        }
        else{
            if (!isset($value['url']) || !$value['url']) continue;
            $this_value['name'] = isset($value['name']) ? $value['name'] : $value['name'];
            $this_value['url']  = $urlPrefix.'/'.$value['url'];
            $json[] = $this_value;
        }
    }
    $json = json_encode($json);
    return $json;
}


function getDecodeJson($val=''){
    $result = '';
    if($val) $result = json_decode($val,true);
    return $result;
}