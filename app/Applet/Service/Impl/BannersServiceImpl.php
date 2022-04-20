<?php

namespace App\Applet\Service\Impl;

use App\Applet\Service\IBannersService;
use App\Core\Constant\CommunalStatus;
use App\Models\Banners;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * 轮播图片服务接口实现
 */
class BannersServiceImpl implements IBannersService
{

    /**
     * 轮播图片列表
     * @param int $type
     * @return Builder[]|Collection
     */
    function listview(int $type)
    {
        $dataList = Banners::appletListview($type);

        return $dataList->each(function($item){
            $item->image = config('filesystems.disks.file.url').$item->image;
        });
    }
}
