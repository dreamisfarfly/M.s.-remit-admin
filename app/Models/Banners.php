<?php

namespace App\Models;

use App\Core\Model\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 横幅模型
 */
class Banners extends BaseModel
{

    public $table = 'banner';

    /** 横幅类型 */
    //设计
    const DESIGN = 0;

    //施工
    const BUILD = 1;

    //商城
    const MALl = 2;

    /**
     * 列表
     * @param int $type
     * @return Builder[]|Collection
     */
    public static function appletListview(int $type)
    {
        return self::query()
            ->where('type',$type)
            ->select([
                'title',
                'location as image'
            ])
            ->orderByDesc('weight')
            ->get();
    }

    /**
     * 添加轮播图
     * @param array $data
     * @return bool
     */
    public static function appendBanner(array $data): bool
    {
        return self::query()->insert($data);
    }

    /**
     * 删除轮播图
     * @param int $id
     * @return mixed
     */
    public static function delBanner(int $id):bool
    {
        return self::query()->where('id',$id)->delete();
    }

    /**
     * 更新状态
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function updateBanner(int $id, array $data): bool
    {
        return self::query()
            ->where('id',$id)
            ->update($data);
    }

    /**
     * 查询横幅列表
     * @param array $searchArr
     * @return LengthAwarePaginator
     */
    public static function adminListview(array $searchArr): LengthAwarePaginator
    {
        return self::query()
            ->when(isset($searchArr['type']),function($query)use($searchArr){
                $query->where('type',$searchArr['type']);
            })
            ->orderByDesc('created_at')
            ->paginate(10);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function details(int $id)
    {
        return self::query()
            ->select(['id','title','status','type','location','weight'])
            ->find($id);
    }

    /**'
     * 更新轮播图
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updatedBanner(int $id, array $data): int
    {
        return self::query()->where('id',$id)->update($data);
    }

}
