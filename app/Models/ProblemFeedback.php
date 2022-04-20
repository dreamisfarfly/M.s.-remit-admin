<?php

namespace App\Models;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Core\Model\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 帮助反馈模型
 */
class ProblemFeedback extends BaseModel
{

    protected $table = "problem_feedback";

    /**
     * 展示
     */
    const SHOW = 0;

    /**
     * 不展示
     */
    const NOT_SHOW = 1;

    /**
     * 列表
     * @param array $searchParam
     * @return LengthAwarePaginator
     */
    public static function listview(array $searchParam): LengthAwarePaginator
    {
        return self::query()
            ->when(isset($searchParam['title']),function($query)use($searchParam){
                $query->where('title','like','%'.$searchParam['title'].'%');
            })
            ->when(isset($searchParam['status']),function($query)use($searchParam){
                $query->where('status',$searchParam['status']);
            })
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->select(['id','status','title','problem','weight','created_at'])
            ->orderByDesc('id')
            ->paginate(10);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updatedProblemFeedback(int $id, array $data): int
    {
        return self::query()
            ->where('id',$id)
            ->update($data);
    }

    /**
     * 插入
     * @param array $data
     * @return bool
     */
    public static function insertProblemFeedback(array $data): bool
    {
        return self::query()->insert($data);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function show(int $id)
    {
        return self::query()
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->select(['id','status','title','problem','weight','created_at'])
            ->find($id);
    }

}
