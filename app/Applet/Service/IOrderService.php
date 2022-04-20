<?php

namespace App\Applet\Service;

use Illuminate\Http\Request;

/**
 * 订单服务接口
 */
interface IOrderService
{

    /**
     * 列表
     * @param array $params
     * @return mixed
     */
    function listview(array $params);

    /**
     * 详情
     * @param int $id
     * @return mixed
     */
    function show(int $id);

    /**
     * 订单信息
     * @param array $data
     * @return mixed
     */
    function orderInformation(array $data);

    /**
     * 创建订单
     * @param array $data
     * @return mixed
     */
    function createdOrder(array $data);

    /**
     * 支付
     * @param int $id
     * @param int $userId
     * @return mixed
     */
    function pay(int $id, int $userId);

    /**
     * 支付回调
     * @param Request $request
     * @return mixed
     */
    function callback(Request $request);

    /**
     * 订单详情
     * @param string $orderNo
     * @return mixed
     */
    function showByOrderNo(string $orderNo);

    /**
     * 更新订单
     * @param int $id
     * @param array $data
     * @return mixed
     */
    function updatedOrder(int $id, array $data);

    /**
     * 取消支付
     * @param int $id
     * @param int $userId
     * @return mixed
     */
    function cancelPayment(int $id, int $userId);

    /**
     * 删除订单
     * @param int $id
     * @param int $userId
     * @return mixed
     */
    function delOrder(int $id, int $userId);

    /**
     * 确认收货
     * @param int $id
     * @param int $userId
     * @return mixed
     */
    function confirmReceipt(int $id, int $userId);

    /**
     * 确认完成
     * @param int $id
     * @param int $userId
     * @return mixed
     */
    function confirmCompleted(int $id, int $userId);
}
