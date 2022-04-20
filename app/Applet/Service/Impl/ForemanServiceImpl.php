<?php

namespace App\Applet\Service\Impl;

use App\Applet\Service\IForemanService;
use App\Models\Foreman;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * 工长服务接口实现
 */
class ForemanServiceImpl implements IForemanService
{

    /**
     * 列表
     * @return Builder[]|Collection
     */
    function listview()
    {
        $dataInfo = Foreman::foremanListview();

        return $dataInfo->each(function($item){
            $item->buddha = config('filesystems.disks.file.url').$item->buddha;
        });
    }

}
