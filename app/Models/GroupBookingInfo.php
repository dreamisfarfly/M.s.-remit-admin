<?php

namespace App\Models;

use App\Core\Model\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 拼团详情
 */
class GroupBookingInfo extends BaseModel
{

    public $table = 'group_booking_info';

    /**
     * 队长
     */
    const CAPTAIN = 0;

    /**
     * 队员
     */
    const PLAYER = 1;

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updateGroupBooking(int $id, array $data): int
    {
        return self::query()->where('id',$id)->update($data);
    }

    /**
     * 详情
     * @param int $groupActivityId
     * @return Builder[]|Collection
     */
    public static function listview(int $groupActivityId)
    {
        return self::query()
            ->where('group_activity_id',$groupActivityId)
            ->with(['order'=>function($query){
                $query->with('user');
            },'groupBooking'])
            ->orderByDesc('type')
            ->select(['id','group_activity_id','type','order_id'])
            ->get();
    }

    /**
     * 添加获取编号
     * @param array $data
     * @return int
     */
    public static function addGetId(array $data): int
    {
        return self::query()->insertGetId($data);
    }

    /**
     * 报名数量
     * @param int $groupActivityId
     * @return int
     */
    public static function registrationNumber(int $groupActivityId): int
    {
        return self::query()
            ->where('group_activity_id',$groupActivityId)
            ->count();
    }

    /**
     * @return BelongsTo
     */
    public function groupBooking(): BelongsTo
    {
        return $this->belongsTo(GroupBooking::class,'group_activity_id','id');
    }

    /**
     * @return HasOne
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class,'id','order_id');
    }

}
