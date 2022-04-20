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
 * 商品模型
 */
class Goods extends BaseModel
{

    public $table = 'goods';

    /**
     * 增加库存
     * @param int $id
     * @param int $count
     * @return int
     */
    public static function incrementGoodsIncrement(int $id, int $count): int
    {
        return self::query()->where('id',$id)->increment('inventory',$count);
    }

    /**
     * 减少库存
     * @param int $id
     * @param int $count
     * @return int
     */
    public static function decrementGoodsInventory(int $id, int $count): int
    {
        return self::query()->where('id',$id)->decrement('inventory',$count);
    }

    /**
     * 分类
     * @return Builder[]|Collection
     */
    public static function classifyListview()
    {
        return self::query()
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->select(['id as value','title as label'])
            ->get();
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function show(int $id)
    {
        return self::query()
            ->select(['id','classify_id','type','status','banner','title','surface_plot','price','inventory','details','common_problem'])
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
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updateGoods(int $id, array $data): int
    {
        return self::query()
            ->where('id',$id)
            ->update($data);
    }

    /**
     * 列表
     * @param array $searchParam
     * @return LengthAwarePaginator
     */
    public static function listview(array $searchParam): LengthAwarePaginator
    {
        return self::query()
            ->when(isset($searchParam['classifyId']),function($query)use($searchParam){
                $query->where('classify_id',$searchParam['classifyId']);
            })
            ->when(isset($searchParam['type']),function($query)use($searchParam){
                $query->where('type',$searchParam['type']);
            })
            ->when(isset($searchParam['title']),function($query)use($searchParam){
                $query->where('title','like','%'.$searchParam['title'].'%');
            })
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->with('classify')
            ->select(['id','classify_id','type','status','title','surface_plot','price','inventory','created_at','sales_volume'])
            ->orderByDesc('id')
            ->paginate(10);
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
