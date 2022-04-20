<?php

namespace App\Applet\Service\Impl;

use App\Applet\Service\IClassifyService;
use App\Core\Constant\CommunalStatus;
use App\Models\Classify;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * 商品分类服务接口实现
 */
class ClassifyServiceImpl implements IClassifyService
{

    /**
     * 列表
     *
     * @param int $type
     * @return Builder[]|Collection
     */
    function listview(int $type)
    {
        return Classify::classify($type);
    }

}
