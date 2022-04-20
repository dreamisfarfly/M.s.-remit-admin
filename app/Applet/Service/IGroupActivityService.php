<?php

namespace App\Applet\Service;

/**
 * 团购商品服务接口
 */
interface IGroupActivityService
{

    /**
     * 列表
     * @return mixed
     */
    function listview();

    /**
     * 推荐列表
     * @return mixed
     */
    function recommendListview();

    /**
     * 详情
     * @param int $id
     * @return mixed
     */
    function show(int $id);

}
