<?php

namespace App\Models;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Core\Model\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 热门推荐
 */
class Hot extends BaseModel
{

    protected $table = 'hot';

    /**
     * 左边大图
     */
    const LEFT_LARGE = 0;

    /**
     * 右上小图
     */
    const RIGHT_UP_THUMBNAIL = 1;

    /**
     * 右上小图
     */
    const RIGHT_BELOW_THUMBNAIL = 2;

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
     * 删除
     * @param int $id
     * @return mixed
     */
    public static function del(int $id)
    {
        return self::query()->where('id', $id)->delete();
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updateHot(int $id, array $data): int
    {
        return self::query()->where('id', $id)->update($data);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function show(int $id)
    {
        return self::query()->find($id);
    }

    /**
     * 详情
     * @param array $param
     * @return Builder|Model|mixed|object|null
     */
    public static function detailsByParam(array $param)
    {
        return self::query()
            ->when(isset($param['type']),function($query)use($param){
                $query->where('type',$param['type']);
            })
            ->when(isset($param['status']),function($query)use($param){
                $query->where('status',$param['status']);
            })
            ->first();
    }

    /**
     * 列表
     * @param array $queryParam
     * @return LengthAwarePaginator
     */
    public static function listview(array $queryParam): LengthAwarePaginator
    {
        return self::query()
            ->when(isset($queryParam['type']),function($query)use($queryParam){
                $query->where('type',$queryParam['type']);
            })
            ->orderByDesc('id')
            ->paginate(10);
    }

    /**
     * 热门推荐
     * @return Builder[]|Collection
     */
    public static function hotRecommend()
    {
        return self::query()
            ->where('status',CommunalStatus::SHOW)
            ->select(['id','goods_id','type','surface_plot'])
            ->get();
    }

}
