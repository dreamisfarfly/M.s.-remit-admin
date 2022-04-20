<?php

namespace App\Admin\Service\Impl;

use App\Admin\Service\ICaseService;
use App\Models\ForemanCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 案例服务接口实现
 */
class CaseServiceImpl implements ICaseService
{

    /**
     * 列表
     * @param array $searchParam
     * @return object
     */
    function listview(array $searchParam): object
    {
        $dataInfo = ForemanCase::listview($searchParam);
        $data = collect($dataInfo->items());
        $data->map(function($item){
            $item->surface_plot = config('filesystems.disks.file.url').$item->surface_plot;
            if(null != $item->foreman)
            {
                $item->nickname = $item->foreman->nickname;
                $item->buddha = config('filesystems.disks.file.url').$item->foreman->buddha;
            }
            unset($item->foreman);
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
     * 更新案例
     * @param int $id
     * @param array $data
     * @return int
     */
    function update(int $id, array $data): int
    {
        if(strpos($data['surface_plot'],config('filesystems.disks.file.url')) !== false){
            unset($data['surface_plot']);
        }
       return ForemanCase::updatedForemanCase($id, $data);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    function show(int $id)
    {
        $dataInfo = ForemanCase::show($id);
        if($dataInfo != null)
        {
            $dataInfo->surface_plot = config('filesystems.disks.file.url').$dataInfo->surface_plot;
            $dataInfo->status = (string)$dataInfo->status;
        }
        return $dataInfo;
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    function add(array $data): bool
    {
        return ForemanCase::insert($data);
    }
}
