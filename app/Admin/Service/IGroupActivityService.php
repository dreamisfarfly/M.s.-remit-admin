<?php

namespace App\Admin\Service;

/**
 * 团购商品服务层接口
 */
interface IGroupActivityService
{

    /**
     * 团购商品列表
     * @param array $searchParam
     * @return mixed
     */
    function list(array $searchParam);

    /**
     * 添加
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

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return mixed
     */
    function update(int $id, array $data);

}
