<?php

namespace App\Models;

use App\Admin\AdminCore\Model\BaseModel;
use App\Core\Constant\CommunalStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 地址
 */
class Address extends BaseModel
{

    public $table = 'address';

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    public static function del(int $id)
    {
        return self::query()->where('id',$id)->delete();
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    public static function add(array $data): bool
    {
        return self::query()->insert($data);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function show(int $id)
    {
        return self::query()
            ->select(['id','name','phone','province','city','area','detailed_address','status'])
            ->find($id);
    }

    /**
     * 列表
     * @param int $userId
     * @return Builder[]|Collection
     */
    public static function listview(int $userId)
    {
        return self::query()
            ->where('user_id',$userId)
            ->select(['id','name as consignee','phone','province','city','area','detailed_address','status'])
            ->orderBy('status')
            ->get();
    }

    /**
     * 更新地址
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updateAddress(int $id, array $data): int
    {
        return self::query()->where('id',$id)->update($data);
    }

    /**
     * 更新
     * @param int $userId
     * @param array $data
     * @return int
     */
    public static function updateByUserId(int $userId, array $data): int
    {
        return self::query()->where('user_id',$userId)->update($data);
    }

    /**
     * 默认地址
     * @param int $userId
     * @return Builder|Model|object|null
     */
    public static function defaultSite(int $userId)
    {
        return self::query()
            ->where('user_id',$userId)
            ->where('status',CommunalStatus::YES_DEFAULT)
            ->select(['id','name as consignee','phone','province','city','area','detailed_address','status'])
            ->first();
    }

}
