<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Service\Impl\OrderServiceImpl;
use App\Admin\Service\IOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 订单控制器
 */
class OrderController extends AdminController
{

    /**
     * @var IOrderService|OrderServiceImpl
     */
    public IOrderService $orderService;

    /**
     * @param Request $request
     * @param OrderServiceImpl $orderService
     */
    public function __construct(Request $request, OrderServiceImpl $orderService)
    {
        parent::__construct($request);
        $this->orderService = $orderService;
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        $searchParam = [];
         return AjaxResult::successData(
             $this->orderService->listview($searchParam)
         );
    }

}
