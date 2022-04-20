<?php

namespace App\Applet\Service;

/**
 * 地址服务接口
 */
interface IAddressService
{

    /**
     * 列表
     * @param int $userId
     * @return mixed
     */
    function listview(int $userId);

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    function add(array $data);

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return mixed
     */
    function update(int $id, array $data);

    /**
     * 详情
     * @param int $id
     * @return mixed
     */
    function show(int $id);

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    function del(int $id);

}
