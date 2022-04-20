<?php

namespace App\Admin\Service;

/**
 * 热门推荐服务接口
 */
interface IHotService
{

    /**
     * 列表
     * @param array $queryParam
     * @return mixed
     */
    function listview(array $queryParam);

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
    function updated(int $id, array $data);

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    function del(int $id);

    /**
     * 详情
     * @param int $id
     * @return mixed
     */
    function show(int $id);

}
