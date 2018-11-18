<?php
/**
 * Created by PhpStorm.
 * User: HYC
 * Date: 2018/5/29
 * Time: 17:21
 */

namespace app\manage\model;

use think\facade\Config;
use think\Model;

class AuthRule extends Model
{

	protected $table = 'auth_rule';

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->table = Config::get('database.prefix').$this->table;
    }

}