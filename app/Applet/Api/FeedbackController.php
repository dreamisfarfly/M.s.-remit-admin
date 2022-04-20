<?php

namespace App\Applet\Api;

use App\Applet\Request\FeedbackRequest;
use App\Applet\Service\IFeedbackService;
use App\Applet\Service\Impl\FeedbackServiceImpl;
use App\Core\Domain\AjaxResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * 意见反馈控制器
 */
class FeedbackController extends Controller
{

    /**
     * @var IFeedbackService
     */
    protected IFeedbackService $feedbackService;

    /**
     * @param FeedbackServiceImpl $feedbackService
     */
    public function __construct(FeedbackServiceImpl $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    /**
     * 意见反馈
     * @param FeedbackRequest $feedbackRequest
     * @return JsonResponse
     */
    public function feedback(FeedbackRequest $feedbackRequest): JsonResponse
    {
        return AjaxResult::successData((object)[
            'id' => $this->feedbackService->feedback([
                'user_id' => $feedbackRequest->attributes->get('userId'),
                'type' => $feedbackRequest->get('type'),
                'content' => $feedbackRequest->get('content'),
                'picture' => json_encode($feedbackRequest->get('picture')),
                'contact_way' => $feedbackRequest->get('contactWay')
            ])
        ]);
    }

}
