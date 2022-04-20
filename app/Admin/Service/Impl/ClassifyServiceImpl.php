<?php

namespace App\Admin\Service\Impl;

use App\Admin\Service\IClassifyService;
use App\Core\Constant\CommunalStatus;
use App\Models\Classify;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * 分类服务接口实现
 */
class ClassifyServiceImpl implements IClassifyService
{

    /**
     * 分类列表
     * @param Request $request
     * @return LengthAwarePaginator
     */
    function list(Request $request): LengthAwarePaginator
    {
        $data = [];
        if($request->exists('type'))
        {
            $data['type'] = $request->get('type');
        }
        return Classify::listview($data);
    }

    /**
     * 删除
     * @param int $id
     * @return int
     */
    function del(int $id): int
    {
        return Classify::updatedClassify($id,['is_del'=>CommunalStatus::YES_DELETE]);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    function update(int $id, array $data): int
    {
        return Classify::updatedClassify($id,$data);
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    function add(array $data): bool
    {
        return Classify::insertClassify($data);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    function show(int $id)
    {
        $dataInfo = Classify::classifyShow($id);
        if($dataInfo != null){
            $dataInfo->status = (string)$dataInfo->status;
            $dataInfo->type = (string)$dataInfo->type;
        }
        return $dataInfo;
    }

    /**
     * 分类
     * @param int $type
     * @return Builder[]|Collection
     */
    function classifyList(int $type)
    {
        return Classify::classifyList($type);
    }
}
