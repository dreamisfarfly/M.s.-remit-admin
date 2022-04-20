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
 * 作品
 */
class Production extends BaseModel
{

    protected $table = 'production';

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    public static function addProduction(array $data): bool
    {
        return self::query()->insert($data);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updatedProduction(int $id, array $data): int
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
            ->when(isset($searchParam['classifyId']),function($query)use($searchParam){
                $query->where('classify_id',$searchParam['classifyId']);
            })
            ->when(isset($searchParam['designerId']),function ($query)use($searchParam){
                $query->where('designer_id',$searchParam['designerId']);
            })
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->with(['designer','classify'])
            ->select(['id','surface_plot','classify_id','genre','designer_id','title','browse_number','created_at'])
            ->orderByDesc('id')
            ->paginate(10);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function show(int $id)
    {
        return self::query()
            ->select(['id','surface_plot','classify_id','genre','designer_id','title','browse_number','details','created_at'])
            ->find($id);
    }

    /**
     * 设计
     * @return BelongsTo
     */
    public function designer(): BelongsTo
    {
        return $this->belongsTo(Designer::class,'designer_id','id')
            ->select(['id','nickname','buddha']);
    }

    /**
     * 分类
     * @return BelongsTo
     */
    public function classify(): BelongsTo
    {
        return $this->belongsTo(Classify::class,'classify_id','id')
            ->select(['id','title']);
    }

}
