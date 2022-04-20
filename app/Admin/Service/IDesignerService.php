<?php

namespace App\Admin\Service;

/**
 * 设计师服务接口
 */
interface IDesignerService
{

    /**
     * 列表
     * @param array $queryParam
     * @return mixed
     */
    function listview(array $queryParam);

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    function del(int $id);

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
    function classifyListview();

}
