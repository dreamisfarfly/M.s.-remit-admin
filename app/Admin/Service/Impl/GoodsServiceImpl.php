<?php

namespace App\Admin\Service\Impl;

use App\Admin\Service\IGoodsService;
use App\Models\Goods;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * 商品服务接口实现
 */
class GoodsServiceImpl implements IGoodsService
{

    /**
     * 列表
     * @param array $searchParam
     * @return mixed
     */
    function listview(array $searchParam)
    {
        $dataInfo = Goods::listview($searchParam);
        $data = collect($dataInfo->items());
        $data->map(function($item){
            if($item->classify != null)
            {
                $item->classifyName = $item->classify->title;
            }
            unset($item->classify);
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
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    function update(int $id, array $data): int
    {
        if(strpos($data['surface_plot'],config('filesystems.disks.file.url')) !== false){
            unset($data['surface_plot']);
        }
        foreach ($data['banner'] as &$item){
            if(strpos($item,config('filesystems.disks.file.url')) !== false){
                $count = strpos($item,config('filesystems.disks.file.url'));
                $strLen = strlen(config('filesystems.disks.file.url'));
                $item = substr_replace($item,"",$count,$strLen);
            }
        }
        $data['banner'] = json_encode($data['banner']);

        return Goods::updateGoods($id,$data);
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    function add(array $data): bool
    {
        return Goods::add($data);
    }

    /**
     * 详情
     * @param int $id
     * @return mixed
     */
    function show(int $id)
    {
        $data = Goods::show($id);
        if($data != null){
            $data->surface_plot = config('filesystems.disks.file.url').$data->surface_plot;
            $data->type = (string)$data->type;
            $data->status = (string)$data->status;
            $bannerArr = collect(json_decode($data->banner));
            $bannerArr->each(function($v,$k)use($bannerArr){
                $bannerArr[$k] = config('filesystems.disks.file.url').$v;
            });
            $data->banner = $bannerArr;
        }
        return $data;
    }

    /**
     * 分类列表
     * @return Builder[]|Collection
     */
    function classifyListview()
    {
        return Goods::classifyListview();
    }
}
