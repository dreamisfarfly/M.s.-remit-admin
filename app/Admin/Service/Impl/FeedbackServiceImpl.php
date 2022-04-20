<?php

namespace App\Admin\Service\Impl;

use App\Admin\Service\IFeedbackService;
use App\Models\Feedback;
use Illuminate\Http\Request;

/**
 * 反馈服务接口实现
 */
class FeedbackServiceImpl implements IFeedbackService
{

    /**
     * 反馈列表
     * @param array $searchParam
     * @return object
     */
    function listview(array $searchParam): object
    {
        $feedbackInfo =  Feedback::listview($searchParam);
        $dataInfo = collect($feedbackInfo->items());
        $dataInfo->map(function($item){
            $data = json_decode($item->picture);
            foreach ($data as &$v)
            {
                $v = config('filesystems.disks.file.url').$v;
            }
            $item->picture = $data;
            if($item->users != null)
            {
                $item->nickname = $item->users->nickname;
                $item->avatar_url = $item->users->avatar_url;
                unset($item->users);
            }
            unset($item->user_id);
        });
        return (object)[
            'data' => $dataInfo,
            'meta' => [
                'total' => $feedbackInfo->total(),
                'page' => $feedbackInfo->currentPage()
            ]
        ];
    }

    /**
     * 处理
     * @param int $id
     * @return int
     */
    function dispose(int $id): int
    {
        return Feedback::updateFeedback($id,['status'=>Feedback::PROCESSED]);
    }
}
