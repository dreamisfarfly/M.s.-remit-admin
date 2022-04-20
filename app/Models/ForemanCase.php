<?php

namespace App\Models;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Model\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 案例
 */
class ForemanCase extends BaseModel
{

    public $table = 'case';

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
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
            ->select(['id','foreman_id','title','surface_plot','status','detail','created_at'])
            ->find($id);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updatedForemanCase(int $id, array $data): int
    {
        return self::query()->where('id',$id)->update($data);
    }

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
            ->with('foreman')
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->select(['id','foreman_id','title','surface_plot','status','created_at'])
            ->orderByDesc('id')
            ->paginate(10);
    }

    /**
     * 工长
     * @return BelongsTo
     */
    public function foreman(): BelongsTo
    {
        return $this->belongsTo(Foreman::class,'foreman_id','id')
            ->select(['id','nickname','buddha']);
    }

}
