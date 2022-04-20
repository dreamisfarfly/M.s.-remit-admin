<?php

namespace App\Models;

use App\Core\Model\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 用户模型
 */
class User extends BaseModel
{

    public $table = 'user';

    /**
     * 后台查询用户信息列表
     * @param array $search
     * @return LengthAwarePaginator
     */
    public static function adminGetUserInfoList(array $search): LengthAwarePaginator
    {
        return self::query()
            ->orderByDesc('id')
            ->paginate(10);
    }

    /**
     * 通过用户openid获取用户信息
     * @param string $openid
     * @return Builder|Model|object|null
     */
    public static function getUserInfoByOpen(string $openid)
    {
        return self::query()
            ->where('open_id',$openid)
            ->select(['id','status','avatar_url','open_id','nickname','created_at'])
            ->first();
    }

    /**
     * 通过用户编号查询用户信息
     * @param int $id
     * @return Builder|Model|object|null
     */
    public static function getUserInfoById(int $id)
    {
        return self::query()
            ->where('id',$id)
            ->select(['id','status','avatar_url','open_id','nickname','created_at'])
            ->first();
    }

    /**
     * 添加用户返回编号
     * @param array $data
     * @return int
     */
    public static function addUserGetId(array $data): int
    {
        return self::query()->insertGetId($data);
    }

}
