<?php

namespace App\Models;

use App\Admin\AdminCore\Model\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 订单信息
 */
class OrderInfo extends BaseModel
{

    public $table = 'order_info';

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
     * 订单详情
     * @param int $orderId
     * @param int $type
     * @return array|Builder[]|Collection
     */
    public static function listviewByOrderIdAndType(int $orderId, int $type)
    {
        return self::query()
            ->when($type == 0, function($query){
                $query->with('goods');
            })
            ->when($type == 1, function($query){

            })
            ->where('order_id',$orderId)
            ->get();
    }

    /**
     * 关联商品
     * @return BelongsTo
     */
    public function goods(): BelongsTo
    {
        return $this->belongsTo(Goods::class,'goods_id','id')
            ->select(['id','title','surface_plot','price']);
    }

    /**
     * 关联商品
     * @return BelongsTo
     */
    public function groupActivity(): BelongsTo
    {
        return $this->belongsTo(GroupActivity::class,'goods_id','id')
            ->select(['id','title','surface_plot','group_price','clustering_count']);
    }

}
