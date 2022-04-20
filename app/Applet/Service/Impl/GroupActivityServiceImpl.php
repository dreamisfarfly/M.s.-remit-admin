<?php

namespace App\Applet\Service\Impl;

use App\Applet\Service\IGroupActivityService;
use App\Models\GroupActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 团购商品服务接口
 */
class GroupActivityServiceImpl implements IGroupActivityService
{

    /**
     * 列表
     * @return object
     */
    function listview(): object
    {
        $dataInfo = GroupActivity::groupActivityListview();
        $data = collect($dataInfo->items());
        $data->each(function($item){
            $item->surface_plot = config('filesystems.disks.file.url').$item->surface_plot;
            if($item->goods != null)
            {
                $item->price =$item->goods->price;
            }
            unset($item->goods);
        });
        return (object)[
            'data' => $data,
            'meta' => [
                'page' => $dataInfo->currentPage(),
                'total' => $dataInfo->total(),
                'lastPage' => $dataInfo->lastPage()
            ]
        ];
    }

    /**
     * 推荐列表
     * @return Builder[]|Collection
     */
    function recommendListview()
    {
        $dataInfo = GroupActivity::recommend();
        return $dataInfo->each(function($item){
            $item->surface_plot = config('filesystems.disks.file.url').$item->surface_plot;
            if($item->goods != null)
            {
                $item->price =$item->goods->price;
            }
            unset($item->goods);
        });
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    function show(int $id)
    {
        $dataInfo = GroupActivity::show($id);
        if($dataInfo != null)
        {
            if($dataInfo->goods != null)
            {
                $dataInfo->price = $dataInfo->goods->price;
                $banner = collect(json_decode($dataInfo->goods->banner));
                $arr = [];
                $banner->each(function($item)use(&$arr){
                   array_push($arr,config('filesystems.disks.file.url').$item);
                });
                $dataInfo->banner = $arr;
                $dataInfo->details = $dataInfo->goods->details;
                $dataInfo->common_problem = $dataInfo->goods->common_problem;
                $dataInfo->second = strtotime($dataInfo->end_time) - time();
                unset($dataInfo->goods);
            }
        }
        return $dataInfo;
    }
}
