<?php

namespace App\Applet\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Applet\Service\IGroupBookingService;
use App\Applet\Service\Impl\GroupBookingServiceImpl;
use App\Core\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 拼团控制器
 */
class GroupBookingController extends ApiController
{

    /**
     * @var IGroupBookingService|GroupBookingServiceImpl
     */
    protected IGroupBookingService $groupBookingService;

    /**
     * @param Request $request
     * @param GroupBookingServiceImpl $groupBookingService
     */
    public function __construct(Request $request, GroupBookingServiceImpl $groupBookingService)
    {
        parent::__construct($request);
        $this->groupBookingService = $groupBookingService;
    }

    /**
     * 拼团列表
     * @param int $goodsId
     * @return JsonResponse
     */
    public function listview(int $goodsId): JsonResponse
    {
        return AjaxResult::successData(
            $this->groupBookingService->listview($goodsId)
        );
    }

    /**
     * 拼团详情
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return AjaxResult::successData(
            $this->groupBookingService->show($id)
        );
    }

}
