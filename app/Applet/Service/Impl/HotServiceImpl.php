<?php

namespace App\Applet\Service\Impl;

use App\Applet\Service\IHotService;
use App\Models\Hot;

/**
 * 热门推荐服务接口实现
 */
class HotServiceImpl implements IHotService
{

    /**
     * 热门推荐 RIGHT_BELOW_THUMBNAIL
     * @return object
     */
    public function hot(): object
    {
        $dataInfo = Hot::hotRecommend();
        $leftLarge = null;
        $rightUpThumbnail = null;
        $rightBelowThumbnail = null;
        foreach ($dataInfo as $item)
        {
            $item->surface_plot = config('filesystems.disks.file.url').$item->surface_plot;
            if($item->type == Hot::LEFT_LARGE)
                $leftLarge = $item;
            if($item->type == Hot::RIGHT_UP_THUMBNAIL)
                $rightUpThumbnail = $item;
            if($item->type == Hot::RIGHT_BELOW_THUMBNAIL)
                $rightBelowThumbnail = $item;
        }
        return (object)[
            'leftLarge' => $leftLarge,
            'rightUpThumbnail' => $rightUpThumbnail,
            'rightBelowThumbnail' => $rightBelowThumbnail
        ];
    }
}
