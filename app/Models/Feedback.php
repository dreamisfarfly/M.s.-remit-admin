<?php

namespace App\Models;

use App\Core\Model\BaseModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 意见反馈模型
 */
class Feedback extends BaseModel
{

    protected $table = 'feedback';

    /**
     * 未处理
     */
    const UNTREATED = 0;

    /**
     * 已处理
     */
    const PROCESSED = 1;

    /**
     * 反馈列表
     * @param array $searchParam
     * @return LengthAwarePaginator
     */
    public static function listview(array $searchParam): LengthAwarePaginator
    {
        return self::query()
            ->when(isset($searchParam['nickname']),function($query)use($searchParam){
                $query->whereHas('users',function($query)use($searchParam){
                    $query->where('nickname','like','%'.$searchParam['nickname'].'%');
                });
            })
            ->when(isset($searchParam['status']),function ($query)use($searchParam){
                $query->where('status',$searchParam['status']);
            })
            ->when(isset($searchParam['type']),function ($query)use($searchParam){
                $query->where('type',$searchParam['type']);
            })
            ->with('users')
            ->select(['id','user_id','status','type','content','picture','contact_way','created_at'])
            ->orderByDesc('id')
            ->paginate(10);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    public static function updateFeedback(int $id, array $data): int
    {
        return self::query()
            ->where('id',$id)
            ->update($data);
    }

    /**
     * 添加反馈
     * @param array $data
     * @return int
     */
    public static function addFeedback(array $data): int
    {
        return self::query()->insertGetId($data);
    }

    /**
     * 关联用户
     * @return BelongsTo
     */
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
