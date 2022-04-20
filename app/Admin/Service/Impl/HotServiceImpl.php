<?php

namespace App\Admin\Service\Impl;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\Service\IHotService;
use App\Models\Hot;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 热门推荐服务接口实现
 */
class HotServiceImpl implements IHotService
{

    /**
     * 列表
     * @param array $queryParam
     * @return object
     */
    function listview(array $queryParam): object
    {
        $dataList = Hot::listview($queryParam);
        $data = collect($dataList->items());
        $data->map(function($item){
            $item->surface_plot = config('filesystems.disks.file.url').$item->surface_plot;
        });
        return (object)[
            'data' => $data,
            'meta' => [
                'total' => $dataList->total(),
                'lastPage' => $dataList->lastPage(),
                'page' => $dataList->currentPage()
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
        try {
            if($data['status'] == CommunalStatus::SHOW)
            {
                $info = Hot::detailsByParam(['type'=>$data['type'],'status'=>CommunalStatus::SHOW]);
                if($info != null){
                    Hot::updateHot($info->id,['status'=>CommunalStatus::HIDE]);
                }
            }
            Hot::add($data);
        }catch (\Exception $e){
            return false;
        }
        return true;
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return bool
     */
    function updated(int $id, array $data): bool
    {
        try {
            if(strpos($data['surface_plot'],config('filesystems.disks.file.url')) !== false){
                unset($data['surface_plot']);
            }
            if($data['status'] == CommunalStatus::SHOW)
            {
                $info = Hot::detailsByParam(['type'=>$data['type'],'status'=>CommunalStatus::SHOW]);
                if($info != null){
                    Hot::updateHot($info->id,['status'=>CommunalStatus::HIDE]);
                }
            }
            Hot::updateHot($id, $data);
        }catch (\Exception $e){
            return false;
        }
        return true;
    }

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    function del(int $id)
    {
        return Hot::del($id);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    function show(int $id)
    {
        $dataInfo = Hot::show($id);
        if($dataInfo != null)
        {
            $dataInfo->surface_plot = config('filesystems.disks.file.url').$dataInfo->surface_plot;
            $dataInfo->status = (string)$dataInfo->status;
            $dataInfo->type = (string)$dataInfo->type;
        }
        return $dataInfo;
    }
}
