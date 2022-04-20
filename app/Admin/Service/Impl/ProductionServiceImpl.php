<?php

namespace App\Admin\Service\Impl;

use App\Admin\Service\IProductionService;
use App\Models\Production;

/**
 * 作品服务接口实现
 */
class ProductionServiceImpl implements IProductionService
{

    /**
     * 列表
     * @param array $searchParam
     * @return object
     */
    function listview(array $searchParam): object
    {
        $dataList = Production::listview($searchParam);
        $data = collect($dataList->items());
        $data->map(function($item){
            $item->surface_plot = config('filesystems.disks.file.url').$item->surface_plot;
            if($item->designer != null)
            {
                $item->nickname = $item->designer->nickname;
                $item->buddha = config('filesystems.disks.file.url').$item->designer->buddha;
            }
            if($item->classify != null){
                $item->classifyName = $item->classify->title;
            }
            unset($item->classify);
            unset($item->designer);
        });
        return (object)[
            'data' => $data,
            'meta' => [
                'total' => $dataList->total(),
                'page' => $dataList->currentPage(),
                'lastPage' => $dataList->lastPage()
            ]
        ];
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    function updated(int $id, array $data): int
    {
        if(strpos($data['surface_plot'],config('filesystems.disks.file.url')) !== false){
            unset($data['surface_plot']);
        }
        return Production::updatedProduction($id,$data);
    }

    /**
     * 添加作品
     * @param array $data
     * @return bool
     */
    function add(array $data): bool
    {
        return Production::addProduction($data);
    }

    /**
     * 详情
     * @param int $id
     * @return mixed
     */
    function show(int $id)
    {
        $dataInfo = Production::show($id);
        if($dataInfo != null)
        {
            $dataInfo->surface_plot =  config('filesystems.disks.file.url').$dataInfo->surface_plot;
        }
        return $dataInfo;
    }
}
