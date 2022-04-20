<?php

namespace App\Admin\Service;

/**
 * 案例服务接口
 */
interface ICaseService
{

    /**
     * 列表
     * @param array $searchParam
     * @return mixed
     */
    function listview(array $searchParam);

    /**
     * 更新案例
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
     * 添加
     * @param array $data
     * @return mixed
     */
    function add(array $data);

}
