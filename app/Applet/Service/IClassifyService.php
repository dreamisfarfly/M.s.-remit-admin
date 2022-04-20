<?php

namespace App\Applet\Service;

/**
 * 商品分类服务接口
 */
interface IClassifyService
{

    /**
     * 列表
     *
     * @param int $type
     * @return mixed
     */
    function listview(int $type);

}
