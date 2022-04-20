<?php

namespace App\Applet\Service\Impl;

use App\Applet\Service\IDesignerService;
use App\Models\Designer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * 设计师服务接口实现
 */
class DesignerServiceImpl implements IDesignerService
{

    /**
     * 推荐
     * @return Builder[]|Collection
     */
    function excellentDesigner()
    {
        $dataList = Designer::excellentDesigner();
        return $dataList->each(function ($item){
            $item->buddha = config('filesystems.disks.file.url').$item->buddha;
        });
    }

}
