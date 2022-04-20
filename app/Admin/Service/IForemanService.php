<?php

namespace App\Admin\Service;

/**
 * 工长服接口
 */
interface IForemanService
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
    function update(int $id, array $data);

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
     * 分类
     * @return mixed
     */
    function classify();

}
