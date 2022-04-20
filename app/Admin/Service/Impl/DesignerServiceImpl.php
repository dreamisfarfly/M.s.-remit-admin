<?php

namespace App\Admin\Service\Impl;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\Service\IDesignerService;
use App\Models\Designer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 设计师服务接口实现
 */
class DesignerServiceImpl implements IDesignerService
{

    /**
     * 列表
     * @param array $queryParam
     * @return object
     */
    function listview(array $queryParam): object
    {
        $dataList = Designer::listview($queryParam);
        $data = collect($dataList->items());
        $data->map(function($item){
            $item->buddha = config('filesystems.disks.file.url').$item->buddha;
            $item->good_style = json_decode($item->good_style);
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
     * 删除
     * @param int $id
     * @return int
     */
    function del(int $id): int
    {
        return Designer::updateDesigner($id,[
            'is_del' => CommunalStatus::YES_DELETE
        ]);
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
        return Designer::updateDesigner($id,$data);
    }


    /**
     * 添加
     * @param array $data
     * @return bool
     */
    function add(array $data): bool
    {
        return Designer::insertDesigner($data);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    function show(int $id)
    {
        $dataInfo = Designer::show($id);
        if($dataInfo != null)
        {
            $dataInfo->status = (string)$dataInfo->status;
            $dataInfo->is_recommend = (string)$dataInfo->is_recommend;
            $dataInfo->buddha = config('filesystems.disks.file.url').$dataInfo->buddha;
            $dataInfo->good_style = json_decode($dataInfo->good_style);
        }
        return $dataInfo;
    }

    /**
     * 分类
     * @return Builder[]|Collection
     */
    function classifyListview()
    {
        return Designer::classifyListview();
    }
}
