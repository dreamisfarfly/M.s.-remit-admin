<?php

namespace App\Admin\Service;

/**
 * 订单服务接口
 */
interface IOrderService
{

    /**
     * 列表
     * @param array $searchParam
     * @return mixed
     */
    function listview(array $searchParam);

}
