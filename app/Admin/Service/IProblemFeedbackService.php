<?php

namespace App\Admin\Service;

/**
 * 反馈问题服务接口
 */
interface IProblemFeedbackService
{

    /**
     * 列表
     * @param array $searchParam
     * @return mixed
     */
    function listview(array $searchParam);

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    function delete(int $id);

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return mixed
     */
    function update(int $id, array $data);

    /**
     * 新增
     * @param array $data
     * @return mixed
     */
    function insert(array $data);

    /**
     * 详情
     * @param int $id
     * @return mixed
     */
    function show(int $id);

}
