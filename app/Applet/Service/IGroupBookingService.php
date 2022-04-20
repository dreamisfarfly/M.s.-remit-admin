<?php

namespace App\Applet\Service;

/**
 * 拼团服务接口
 */
interface IGroupBookingService
{

    /**
     * 商品编号
     * @param int $goodsId
     * @return mixed
     */
    function listview(int $goodsId);

    /**
     * 拼团详情
     * @param int $id
     * @return mixed
     */
    function show(int $id);

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return mixed
     */
    function updated(int $id, array $data);

}
