<?php

namespace App\Models;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Model\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 工长模型
 */
class Foreman extends BaseModel
{

    protected $table = 'foreman';

    /**
     * 分类
     * @return Builder[]|Collection
     */
    public static function classify()
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
            ->select(['id','nickname','buddha','site_name','working_seniority','created_at'])
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
    public static function updateForeman(int $id, array $data): int
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
            ->when(isset($searchParam['nickname']),function($query)use($searchParam){
                $query->where('nickname','like','%'.$searchParam['nickname'].'%');
            })
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->select(['id','nickname','buddha','site_name','working_seniority','created_at'])
            ->orderByDesc('id')
            ->paginate(10);
    }

    /**
     * 列表
     * @return Builder[]|Collection
     */
    public static function foremanListview()
    {
        return self::query()
            ->where('is_del',CommunalStatus::NOT_DELETE)
            ->select(['id','nickname','buddha','site_name','working_seniority'])
            ->get();
    }

}
