<?php

namespace App\Admin\Service;

/**
 * 作品服务接口
 */
interface IProductionService
{

    /**
     * 列表
     * @param array $searchParam
     * @return mixed
     */
    function listview(array $searchParam);

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return mixed
     */
    function updated(int $id, array $data);

    /**
     * 添加作品
     * @param array $data
     * @return mixed
     */
    function add(array $data);

    /**
     * 详情
     * @param int $id
     * @return mixed
     */
    function show(int $id);

}
