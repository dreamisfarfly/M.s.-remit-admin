<?php

namespace App\Applet\Api;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Domain\AjaxResult;
use App\Applet\Request\CreateOrderRequest;
use App\Applet\Request\OrderInformationRequest;
use App\Applet\Service\Impl\OrderServiceImpl;
use App\Applet\Service\IOrderService;
use App\Core\Api\ApiController;
use App\Core\Exception\ParametersException;
use App\Models\Order;
use EasyWeChat\Kernel\Exceptions\Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 订单控制器
 */
class OrderController extends ApiController
{

    /**
     * @var IOrderService|OrderServiceImpl
     */
    protected IOrderService $orderService;

    /**
     * @param Request $request
     * @param OrderServiceImpl $orderServiceImpl
     */
    public function __construct(Request $request, OrderServiceImpl $orderServiceImpl)
    {
        parent::__construct($request);
        $this->orderService = $orderServiceImpl;
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        $queryParam = [];
        if ($this->request->exists('status') && $this->request->get('status') != '') {
            $queryParam['status'] = $this->request->get('status');
        }
        $queryParam['userId'] = $this->request->attributes->get('userId');
        $queryParam['isDel'] = CommunalStatus::NOT_DELETE;
        return AjaxResult::successData(
            $this->orderService->listview($queryParam)
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
            $this->orderService->show($id)
        );
    }

    /**
     * 订单信息
     * @param OrderInformationRequest $orderInformationRequest
     * @return JsonResponse
     */
    public function orderInformation(OrderInformationRequest $orderInformationRequest): JsonResponse
    {
        return AjaxResult::successData(
            $this->orderService->orderInformation([
                'user_id' => $orderInformationRequest->attributes->get('userId'),
                'id' => $orderInformationRequest->get('id'),
                'type' => $orderInformationRequest->get('type'),
                'count' => $orderInformationRequest->get('count')
            ])
        );
    }

    /**
     * 创建订单
     * @param CreateOrderRequest $createOrderRequest
     * @return JsonResponse
     * @throws ParametersException
     */
    public function createOrder(CreateOrderRequest $createOrderRequest): JsonResponse
    {
        $orderInfo = [
            'userId' => $createOrderRequest->attributes->get('userId'),
            'id' => $createOrderRequest->get('id'),
            'type' => $createOrderRequest->get('type'),
            'count' => $createOrderRequest->get('count'),
            'addressId' => $createOrderRequest->get('addressId'),
            'deliveryTime' => $createOrderRequest->get('deliveryTime'),
            'leaveWord' => $createOrderRequest->get('leaveWord'),
        ];
        if ($createOrderRequest->exists('groupId') && $createOrderRequest->get('groupId') != '') {
            $orderInfo['groupId'] = $createOrderRequest->get('groupId');
        }
        return AjaxResult::successData(
            $this->orderService->createdOrder($orderInfo)
        );
    }

    /**
     * 支付
     * @param int $id
     * @return JsonResponse
     * @throws ParametersException
     */
    public function pay(int $id): JsonResponse
    {
        return AjaxResult::successData(
            $this->orderService->pay($id, $this->request->attributes->get('userId'))
        );
    }

    /**
     * 支付回调
     * @return mixed
     * @throw ParametersException|Exception
     */
    public function callback()
    {
        return $this->orderService->callback($this->request);
    }

    /**
     * 取消支付
     * @param int $id
     * @return JsonResponse
     * @throws ParametersException
     */
    public function cancelPayment(int $id): JsonResponse
    {
        $this->orderService->cancelPayment($id, $this->request->attributes->get('userId'));
        return AjaxResult::success();
    }

    /**
     * 删除订单
     * @param int $id
     * @return JsonResponse
     * @throws ParametersException
     */
    public function delOrder(int $id): JsonResponse
    {
        $this->orderService->delOrder($id,$this->request->attributes->get('userId'));
        return AjaxResult::success();
    }

    /**
     * 确认收货
     * @param int $id
     * @return JsonResponse
     * @throws ParametersException
     */
    public function confirmReceipt(int $id): JsonResponse
    {
        $this->orderService->confirmReceipt($id, $this->request->attributes->get('userId'));
        return AjaxResult::success();
    }

    /**
     * 确认完成
     * @param int $id
     * @return JsonResponse
     * @throws ParametersException
     */
    public function confirmCompleted(int $id): JsonResponse
    {
        $this->orderService->confirmCompleted($id, $this->request->attributes->get('userId'));
        return AjaxResult::success();
    }

    public function cancelOrder(int $id)
    {
        return AjaxResult::success();
    }

}
