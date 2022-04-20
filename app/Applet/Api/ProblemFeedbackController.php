<?php

namespace App\Applet\Api;

use App\Applet\Service\Impl\ProblemFeedbackServiceImpl;
use App\Applet\Service\IProblemFeedbackService;
use App\Core\Api\ApiController;
use App\Core\Domain\AjaxResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 帮助反馈控制器
 */
class ProblemFeedbackController extends ApiController
{

    /**
     * @var IProblemFeedbackService
     */
    protected IProblemFeedbackService $problemFeedbackService;

    /**
     * @param ProblemFeedbackServiceImpl $problemFeedbackService
     * @param Request $request
     */
    public function __construct(ProblemFeedbackServiceImpl $problemFeedbackService, Request $request)
    {
        $this->problemFeedbackService = $problemFeedbackService;
        parent::__construct($request);
    }

    /**
     * 帮助问题
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        return AjaxResult::successData(
            $this->problemFeedbackService->handleListview(null)
        );
    }

}
