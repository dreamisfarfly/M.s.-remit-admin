<?php

namespace App\Admin\Service;

/**
 * 反馈服务接口
 */
interface IFeedbackService
{

    /**
     * 反馈列表
     * @param array $searchParam
     * @return mixed
     */
    function listview(array $searchParam);

    /**
     * 处理
     * @param int $id
     * @return mixed
     */
    function dispose(int $id);

}
