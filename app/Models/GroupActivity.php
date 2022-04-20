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
 * 团购商品
 */
class GroupActivity extends BaseModel
{

    public $table = 'group_activity';

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updateGroupActivity(int $id, array $data): int
    {
        return self::query()->where('id',$id)->update($data);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function show(int $id)
    {
        return self::query()
            ->with('goods')
            ->select([
                'id',
                'goods_id',
                'title',
                'surface_plot',
                'group_price',
                'start_end',
                'end_time',
                'expire_hour',
                'restriction_count',
                'clustering_count',
                'status',
                'created_at'
            ])
            ->find($id);
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    public static function add(array $data): bool
    {
        return self::query()->insert($data);
    }

    /**
     * 列表
     * @param array $searchParam
     * @return LengthAwarePaginator
     */
    public static function listview(array $searchParam): LengthAwarePaginator
    {
        return self::query()
            ->when(isset($searchParam['title']),function ($query)use($searchParam){
                $query->where('title','like','%'.$searchParam['title'].'%');
            })
            ->when(isset($searchParam['status']),function ($query)use($searchParam){
                $query->where('status',$searchParam['status']);
            })
            ->where('is_del', CommunalStatus::NOT_DELETE)
            ->select([
                'id',
                'title',
                'goods_id',
                'surface_plot',
                'group_price',
                'start_end',
                'end_time',
                'expire_hour',
                'restriction_count',
                'clustering_count',
                'status',
                'created_at'
            ])
            ->orderByDesc('id')
            ->paginate(10);
    }

    /**
     * 列表
     * @return LengthAwarePaginator
     */
    public static function groupActivityListview(): LengthAwarePaginator
    {
        return self::query()
            ->where('status',CommunalStatus::ADDED)
            ->where('is_del', CommunalStatus::NOT_DELETE)
            ->with('goods')
            ->select(['id', 'title', 'surface_plot', 'group_price', 'goods_id'])
            ->where('start_end','<=',date('Y-m-d H:i:s'))
            ->where('end_time','>',date('Y-m-d H:i:s'))
            ->orderByDesc('id')
            ->paginate(8);
    }

    /**
     * 推荐
     * @return Builder[]|Collection
     */
    public static function recommend()
    {
        return self::query()
            ->where('status',CommunalStatus::ADDED)
            ->where('is_del', CommunalStatus::NOT_DELETE)
            ->where('is_recommend', CommunalStatus::YES_RECOMMEND)
            ->with('goods')
            ->select(['id', 'title', 'surface_plot', 'group_price', 'goods_id'])
            ->where('start_end','<=',date('Y-m-d H:i:s'))
            ->where('end_time','>',date('Y-m-d H:i:s'))
            ->orderByDesc('id')
            ->get();
    }

    /**
     * 关联用户
     * @return BelongsTo
     */
    public function goods(): BelongsTo
    {
        return $this->belongsTo(Goods::class,'goods_id','id');
    }

}
