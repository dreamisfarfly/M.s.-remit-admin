<?php

namespace App\Admin\Models;

use App\Admin\AdminCore\Model\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 后台用户模型
 */
class SysUsers extends BaseModel
{

    public $table = 'sys_user';

    /**
     * 管理员登录
     * @param string $name
     * @param string $password
     * @return Builder|Model|object|null
     */
    public static function login(string $name, string $password)
    {
        return self::query()
            ->where('user_name',$name)
            ->where('password',md5($password))
            ->select()
            ->first();
    }

    /**
     * 用户信息
     * @param int $id
     * @return Builder|Model|object|null
     */
    public static function userinfo(int $id)
    {
        return self::query()
            ->where('user_id',$id)
            ->first();
    }

}
