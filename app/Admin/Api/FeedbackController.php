<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Service\IFeedbackService;
use App\Admin\Service\Impl\FeedbackServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 反馈控制器
 */
class FeedbackController extends AdminController
{

    /**
     * @var IFeedbackService|FeedbackServiceImpl
     */
    protected IFeedbackService $feedbackService;

    /**
     * @param Request $request
     * @param FeedbackServiceImpl $feedbackService
     */
    public function __construct(Request $request, FeedbackServiceImpl $feedbackService)
    {
        parent::__construct($request);
        $this->feedbackService = $feedbackService;
    }

    /**
     * 反馈列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        $searchParam = [];
        $request = $this->request;
        if($request->exists('nickname') && $request->get('nickname') != '')
        {
            $searchParam['nickname'] = $request->get('nickname');
        }
        if($request->exists('status') && $request->get('status') != '')
        {
            $searchParam['status'] = $request->get('status');
        }
        if($request->exists('type') && $request->get('type') != '')
        {
            $searchParam['type'] = $request->get('type');
        }
        return AjaxResult::successData(
            $this->feedbackService->listview($searchParam)
        );
    }

    /**
     * 处理
     * @param int $id
     * @return JsonResponse
     */
    public function dispose(int $id): JsonResponse
    {
        $this->feedbackService->dispose($id);
        return AjaxResult::success();
    }

}
