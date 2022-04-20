<?php

namespace App\Admin\Service;

/**
 * 订单信息服务层接口
 */
interface IOrderInfoService
{

    /**
     * 列表
     * @param int $orderId
     * @param int $type
     * @return mixed
     */
    function listview(int $orderId, int $type);

}
