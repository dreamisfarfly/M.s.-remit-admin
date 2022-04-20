<?php

namespace App\Admin\Service\Impl;

use App\Admin\Service\IOrderService;
use App\Models\Order;

/**
 * 订单服务接口实现
 */
class OrderServiceImpl implements IOrderService
{

    /**
     * 列表
     * @param array $searchParam
     * @return object
     */
    function listview(array $searchParam): object
    {
        $dataInfo = Order::listview($searchParam);
        $data = collect($dataInfo->items());
        $data->map(function($item){
            if($item->user != null)
            {
                $item->userNickname = $item->user->nickname;
                $item->avatar_url = $item->user->avatar_url;
            }
            unset($item->user);
        });
        return (object)[
            'data' => $data,
            'meta' => [
                'total' => $dataInfo->total(),
                'page' => $dataInfo->currentPage()
            ]
        ];
    }

}
