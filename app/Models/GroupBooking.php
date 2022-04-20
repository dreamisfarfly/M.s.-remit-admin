<?php

namespace App\Models;

use App\Core\Model\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 拼团信息
 */
class GroupBooking extends BaseModel
{

    public $table = 'group_booking';

    /**
     * 过期时间
     */
    const EXPIRES = 120;

    /**
     * 进行中
     */
    const UNDERWAY = 0;

    /**
     * 已过期
     */
    const HAVE_EXPIRED = 1;

    /**
     * 已完成
     */
    const FINISHED = 2;

    /**
     * 更新拼团
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updatedGroupBooking(int $id, array $data): int
    {
        return self::query()->where('id', $id)->update($data);
    }

    /**
     * 详情 崽崽和壮壮
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function show(int $id)
    {
        return self::query()->find($id);
    }

    /**
     * 列表
     * @param int $goodsId
     * @return Builder[]|Collection
     */
    public static function listview(int $goodsId)
    {
        return self::query()
            ->where('goods_id',$goodsId)
            ->where('status',self::UNDERWAY)
            ->with(['groupBookingInfoCaptain'=>function($query){
                $query->where('type',0)->with(['order'=>function($query){
                    $query->with('user');
                }]);
            }])
            ->orderByDesc('id')
            ->select(['id','number_clusters','created_at'])
            ->withCount(['groupBookingInfo as groupCount'])
            ->get();
    }

    /**
     * 拼团详情 队长
     * @return HasOne
     */
    public function groupBookingInfoCaptain(): HasOne
    {
        return $this->hasOne(GroupBookingInfo::class,'group_activity_id','id');
    }

    /**
     * 拼团详情
     * @return HasMany
     */
    public function groupBookingInfo(): HasMany
    {
        return $this->hasMany(GroupBookingInfo::class,'group_activity_id','id');
    }

    /**
     * 添加返回编号
     * @param array $data
     * @return int
     */
    public static function addGetId(array $data): int
    {
        return self::query()->insertGetId($data);
    }

}
