<?php

namespace App\Applet\Service\Impl;

use App\Applet\Service\IProblemFeedbackService;
use App\Core\Constant\CommunalStatus;
use App\Models\ProblemFeedback;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * 帮助反馈服务接口实现
 */
class ProblemFeedbackServiceImpl implements IProblemFeedbackService
{

    /***
     * 帮助反馈列表
     *
     * @return Builder[]|Collection
     */
    function listview()
    {
        return ProblemFeedback::query()
            ->where('status',CommunalStatus::SHOW)
            ->select(['id','title','problem'])
            ->orderByDesc('weight')
            ->get();
    }


    /***
     * 用户操作反馈列表
     *
     * @param int|null $userId
     * @return Builder[]|Collection|null
     */
    function handleListview(?int $userId)
    {
        $data = self::listview();

        return $data->map(function ($item)use($userId){
            if(null == $userId)
                $item->status = -1;
            return $item;
        });
    }
}
