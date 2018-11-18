<?php
/**
 * Created by PhpStorm.
 * User: hyc
 * Date: 2018/9/20
 * Time: 22:45
 */

namespace app\manage\model;


use think\facade\Config;
use think\Model;

class AuthGroup extends Model
{

    protected $table = 'auth_group';

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->table = Config::get('database.prefix').$this->table;
    }

}