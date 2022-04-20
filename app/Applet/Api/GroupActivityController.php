<?php

namespace App\Applet\Api;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Domain\AjaxResult;
use App\Applet\Service\IGroupActivityService;
use App\Applet\Service\Impl\GroupActivityServiceImpl;
use App\Core\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 团购商品
 */
class GroupActivityController extends ApiController
{

    /**
     * @var IGroupActivityService
     */
    protected IGroupActivityService $activityService;

    /**
     * @param Request $request
     * @param GroupActivityServiceImpl $groupActivityServiceImpl
     */
    public function __construct(Request $request, GroupActivityServiceImpl $groupActivityServiceImpl)
    {
        parent::__construct($request);
        $this->activityService = $groupActivityServiceImpl;
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        return AjaxResult::successData(
            $this->activityService->listview()
        );
    }

    /**
     * 推荐列表
     * @return JsonResponse
     */
    public function recommendListview(): JsonResponse
    {
        return AjaxResult::successData(
            $this->activityService->recommendListview()
        );
    }

    /**
     * 详情
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return AjaxResult::successData(
            $this->activityService->show($id)
        );
    }

}
