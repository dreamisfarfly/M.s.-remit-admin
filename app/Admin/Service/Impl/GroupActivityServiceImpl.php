<?php

namespace App\Admin\Service\Impl;

use App\Admin\Service\IGroupActivityService;
use App\Models\GroupActivity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 团购商品服务层接口实现
 */
class GroupActivityServiceImpl implements IGroupActivityService
{

    /**
     * 团购商品列表
     * @param array $searchParam
     * @return object
     */
    function list(array $searchParam): object
    {
        $dataInfo = GroupActivity::listview($searchParam);
        $data = collect($dataInfo->items());
        $data->map(function($item){
            $item->surface_plot = config('filesystems.disks.file.url').$item->surface_plot;
        });
        return (object)[
            'data' => $data,
            'meta' => [
                'page' => $dataInfo->currentPage(),
                'total' => $dataInfo->total()
            ]
        ];
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    function add(array $data): bool
    {
        return GroupActivity::add($data);
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
            $dataInfo->surface_plot = config('filesystems.disks.file.url').$dataInfo->surface_plot;
            $dataInfo->status = (string)$dataInfo->status;
        }
        return $dataInfo;
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    function update(int $id, array $data): int
    {
        if(isset($data['surface_plot']) && strpos($data['surface_plot'],config('filesystems.disks.file.url')) !== false){
            unset($data['surface_plot']);
        }
        return GroupActivity::updateGroupActivity($id,$data);
    }
}
