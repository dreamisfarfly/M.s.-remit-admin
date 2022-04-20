<?php

namespace App\Models;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Model\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 设计师模型
 */
class Designer extends BaseModel
{

    protected $table = 'designer';

    /**
     * 推荐
     */
    const YES_RECOMMEND = 0;

    /**
     * 不推荐
     */
    const NOT_RECOMMEND = 1;

    /**
     * 分类列表
     * @return Builder[]|Collection
     */
    public static function classifyListview()
    {
        return self::query()
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->select(['id as value','nickname as label'])
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
            ->select(['id','nickname','buddha','experience','floor_price','top_price','good_style','status','is_recommend','individual_resume','created_at'])
            ->find($id);
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    public static function insertDesigner(array $data): bool
    {
        return self::query()->insert($data);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updateDesigner(int $id, array $data): int
    {
        return self::query()->where('id',$id)->update($data);
    }

    /**
     * 列表
     * @param array $queryParam
     * @return LengthAwarePaginator
     */
    public static function listview(array $queryParam): LengthAwarePaginator
    {
        return self::query()
            ->when(isset($queryParam['recommend']),function($query)use($queryParam){
                $query->where('is_recommend',$queryParam['recommend']);
            })
            ->when(isset($queryParam['status']),function($query)use($queryParam){
                $query->where('status',$queryParam['status']);
            })
            ->when(isset($queryParam['nickname']),function($query)use($queryParam){
                $query->where('nickname','like','%'.$queryParam['nickname'].'%');
            })
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->select(['id','nickname','buddha','experience','floor_price','top_price','good_style','status','is_recommend','created_at'])
            ->orderByDesc('id')
            ->paginate(10);
    }

    /**
     * 优秀设计师
     * @return Builder[]|Collection
     */
    public static function excellentDesigner()
    {
        return self::query()
            ->where('status',CommunalStatus::SHOW)
            ->where('is_recommend',self::YES_RECOMMEND)
            ->select(['id','nickname','buddha','experience','floor_price','top_price'])
            ->get();
    }

}
