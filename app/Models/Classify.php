<?php

namespace App\Models;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Core\Model\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 商品分类
 */
class Classify extends BaseModel
{

    public $table = 'classify';

    /**
     * 设计师
     */
    const DESIGNER = 0;

    /**
     * 商场
     */
    const SHOPPING_MALL = 1;

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function classifyShow(int $id)
    {
        return self::query()
            ->select(['id','title','type','status','weight'])
            ->find($id);
    }

    /**
     * 新增分类
     * @param array $data
     * @return bool
     */
    public static function insertClassify(array $data): bool
    {
        return self::query()->insert($data);
    }

    /**
     * 更新分类
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updatedClassify(int $id, array $data): int
    {
        return self::query()
            ->where('id',$id)
            ->update($data);
    }

    /**
     * 列表
     * @param array $search
     * @return LengthAwarePaginator
     */
    public static function listview(array $search)
    {
        return self::query()
            ->when(isset($search['type']),function($query)use($search){
               $query->where('type',$search['type']);
            })
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->select(['id','title','type','status','weight','created_at'])
            ->orderByDesc('id')
            ->paginate(10);
    }

    /**
     * 分类
     * @param int $type
     * @return Builder[]|Collection
     */
    public static function classifyList(int $type)
    {
        return self::query()
            ->where('type',$type)
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->select(['id as value','title as label'])
            ->get();
    }

    /**
     * 分类
     * @param int $type
     * @return Builder[]|Collection
     */
    public static function classify(int $type)
    {
        return Classify::query()
            ->where('type',$type)
            ->where('status',CommunalStatus::SHOW)
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->select(['id','title as name'])
            ->orderByDesc('weight')
            ->get();
    }

}
