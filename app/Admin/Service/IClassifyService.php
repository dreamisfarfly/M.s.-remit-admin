<?php

namespace App\Admin\Service;

use Illuminate\Http\Request;

/**
 * 分类服务接口
 */
interface IClassifyService
{

    /**
     * 分类列表
     * @param Request $request
     * @return mixed
     */
    function list(Request $request);

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
     * 分类
     * @param int $type
     * @return mixed
     */
    function classifyList(int $type);

}
