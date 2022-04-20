<?php

namespace App\Applet\Service;

/**
 * 轮播图片服务接口
 */
interface IBannersService
{

    /**
     * 轮播图片列表
     * @param int $type
     * @return mixed
     */
    function listview(int $type);

}
