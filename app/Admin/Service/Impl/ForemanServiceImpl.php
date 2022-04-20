<?php

namespace App\Admin\Service\Impl;

use App\Admin\Service\IForemanService;
use App\Models\Foreman;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 工长服接口实现
 */
class ForemanServiceImpl implements IForemanService
{

    /**
     * 列表
     * @param array $searchParam
     * @return object
     */
    function listview(array $searchParam): object
    {
        $dataInfo = Foreman::listview($searchParam);
        $data = collect($dataInfo->items());
        $data->map(function($item){
            $item->buddha =  config('filesystems.disks.file.url').$item->buddha;
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
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    function update(int $id, array $data): int
    {
        if(strpos($data['buddha'],config('filesystems.disks.file.url')) !== false){
            unset($data['buddha']);
        }
        return Foreman::updateForeman($id,$data);
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    function add(array $data): bool
    {
        return Foreman::add($data);
    }


    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    function show(int $id)
    {
        $dataInfo = Foreman::show($id);
        if($dataInfo != null)
        {
            $dataInfo->buddha = config('filesystems.disks.file.url').$dataInfo->buddha;
        }
        return $dataInfo;
    }

    /**
     * 分类
     * @return Builder[]|Collection
     */
    function classify()
    {
        return Foreman::classify();
    }
}
