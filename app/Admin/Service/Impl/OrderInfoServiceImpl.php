<?php

namespace App\Admin\Service\Impl;

use App\Admin\Service\IOrderInfoService;
use App\Models\OrderInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * 订单信息服务层接口实现
 */
class OrderInfoServiceImpl implements IOrderInfoService
{

    /**
     * 列表
     * @param int $orderId
     * @param int $type
     * @return array|Builder[]|Collection
     */
    function listview(int $orderId, int $type)
    {
        $dataList = OrderInfo::listviewByOrderIdAndType($orderId,$type);
        $dataList->map(function($item){
            if($item->goods != null)
            {
                $item->title = $item->goods->title;
                $item->surface_plot = config('filesystems.disks.file.url').$item->goods->surface_plot;
                $item->price = $item->goods->price;
                unset($item->goods);
            }
        });
        return $dataList;
    }
}
