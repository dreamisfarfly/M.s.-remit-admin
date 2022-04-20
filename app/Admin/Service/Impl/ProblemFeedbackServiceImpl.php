<?php

namespace App\Admin\Service\Impl;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\Service\IProblemFeedbackService;
use App\Models\ProblemFeedback;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 反馈问题服务接口实现
 */
class ProblemFeedbackServiceImpl implements IProblemFeedbackService
{

    /**
     * 列表
     * @param array $searchParam
     * @return LengthAwarePaginator
     */
    function listview(array $searchParam): LengthAwarePaginator
    {
        return ProblemFeedback::listview($searchParam);
    }

    /**
     * 删除
     * @param int $id
     * @return int
     */
    function delete(int $id): int
    {
        return ProblemFeedback::updatedProblemFeedback(
            $id,
            [
                'is_del' => CommunalStatus::YES_DELETE
            ]
        );
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    function update(int $id, array $data): int
    {
        return ProblemFeedback::updatedProblemFeedback($id, $data);
    }

    /**
     * 新增
     * @param array $data
     * @return bool
     */
    function insert(array $data): bool
    {
        return ProblemFeedback::insertProblemFeedback($data);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    function show(int $id)
    {
        $data = ProblemFeedback::show($id);
        if($data != null)
        {
            $data->status = (string)$data->status;
        }
        return $data;
    }
}
