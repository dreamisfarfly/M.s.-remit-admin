<?php

namespace App\Models;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Model\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 订单模型
 */
class Order extends BaseModel
{

    public $table = 'order';

    /**
     * 过期时间/分钟
     */
    const EXPIRATION_TIME = 30;

    /**
     * 普通订单
     */
    const REGULAR_ORDERS = 0;

    /**
     * 拼团订单
     */
    const SPELL_GROUP_ORDER = 1;

    /**
     * 未支付
     */
    const NOT_PAID = 0;

    /**
     * 已过期
     */
    const EXPIRED = 1;

    /**
     * 已支付
     */
    const HAVE_PAID = 2;

    /**
     * 已发货
     */
    const SHIPPED = 3;

    /**
     * 确认收货
     */
    const CONFIRM_RECEIPT = 4;

    /**
     * 完成
     */
    const ACCOMPLISH = 5;

    /**
     * 进行中
     */
    const GROUP_UNDERWAY = 0;

    /**
     * 已过期
     */
    const GROUP_HAVE_EXPIRED = 1;

    /**
     * 已完成
     */
    const GROUP_FULFILLED = 2;



    /**
     * 更新订单
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updatedOrder(int $id, array $data): int
    {
        return self::query()->where('id',$id)->update($data);
    }

    /**
     * 添加订单
     * @param array $data
     * @return int
     */
    public static function addGetId(array $data): int
    {
        return self::query()->insertGetId($data);
    }

    /**
     * 列表
     * @param array $searchParam
     * @return LengthAwarePaginator
     */
    public static function listview(array $searchParam): LengthAwarePaginator
    {
        return self::query()
            ->with('user')
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->paginate(10);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function show(int $id)
    {
        return self::query()
            ->with(['common'=>function($query){
                $query->with('goods');
            },'group'=>function($query){
                $query->with('groupActivity');
            },'user'])
            ->select([
                'id',
                'user_id',
                'type',
                'order_no',
                'status',
                'consignee',
                'phone',
                'province',
                'city',
                'area',
                'detailed_address',
                'time_payment',
                'leave_word',
                'total_price',
                'delivery_time',
                'created_at',
                'group_id'
            ])
            ->find($id);
    }

    /**
     * 详情
     * @param string $orderNo
     * @return Builder|Model|null
     */
    public static function showByOrderNo(string $orderNo)
    {
        return self::query()
            ->where('order_no',$orderNo)
            ->with(['common'=>function($query){
                $query->with('goods');
            },'group'=>function($query){
                $query->with('groupActivity');
            },'user'])
            ->select([
                'id',
                'user_id',
                'type',
                'order_no',
                'status',
                'consignee',
                'phone',
                'province',
                'city',
                'area',
                'detailed_address',
                'time_payment',
                'leave_word',
                'total_price',
                'delivery_time',
                'group_id',
                'created_at'
            ])
            ->first();
    }

    /**
     * 订单列表
     * @param array $queryParam
     * @return LengthAwarePaginator
     */
    public static function orderListview(array $queryParam): LengthAwarePaginator
    {
        return self::query()
            ->where('user_id',$queryParam['userId'])
            ->when(isset($queryParam['status']),function($query)use($queryParam){
                $query->where('status',$queryParam['status']);
            })
            ->when(isset($queryParam['isDel']),function($query)use($queryParam){
                $query->where('is_del',$queryParam['isDel']);
            })
            ->with(['common'=>function($query){
                $query->with('goods');
            },'group'=>function($query){
                $query->with('groupActivity');
            }])
            ->select([
                'id',
                'user_id',
                'type',
                'order_no',
                'status',
                'consignee',
                'phone',
                'province',
                'city',
                'area',
                'detailed_address',
                'time_payment',
                'leave_word',
                'total_price',
                'delivery_time',
                'created_at'
            ])
            ->paginate(10);
    }

    /**
     * 关联用户
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * 订单信息
     * @return HasMany
     */
    public function common(): HasMany
    {
        return $this->hasMany(OrderInfo::class,'order_id','id')
            ->where('type',0);
    }

    /**
     * 订单信息
     * @return HasMany
     */
    public function group(): HasMany
    {
        return $this->hasMany(OrderInfo::class,'order_id','id')
            ->where('type',1);
    }

}
