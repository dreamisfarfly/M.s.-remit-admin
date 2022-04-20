<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Request\OrderInfoListviewRequest;
use App\Admin\Service\Impl\OrderInfoServiceImpl;
use App\Admin\Service\IOrderInfoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 订单信息控制器
 */
class OrderInfoController extends AdminController
{

    /**
     * @var IOrderInfoService|OrderInfoServiceImpl
     */
    protected IOrderInfoService $orderInfoService;

    /**
     * @param Request $request
     * @param OrderInfoServiceImpl $orderInfoService
     */
    public function __construct(Request $request, OrderInfoServiceImpl $orderInfoService)
    {
        parent::__construct($request);
        $this->orderInfoService = $orderInfoService;
    }

    /**
     * 订单详情列表
     * @param OrderInfoListviewRequest $orderInfoListviewRequest
     * @return JsonResponse
     */
    public function listview(OrderInfoListviewRequest $orderInfoListviewRequest): JsonResponse
    {
        return AjaxResult::successData(
            $this->orderInfoService->listview(
                $orderInfoListviewRequest->get('orderId'),
                $orderInfoListviewRequest->get('type')
            )
        );
    }

}
