<?php

namespace App\Applet\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Applet\Request\EditAddressRequest;
use App\Applet\Service\IAddressService;
use App\Applet\Service\Impl\AddressServiceImpl;
use App\Core\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 地址控制器
 */
class AddressController extends ApiController
{

    /**
     * @var IAddressService
     */
    protected IAddressService $addressService;

    /**
     * @param Request $request
     * @param AddressServiceImpl $addressService
     */
    public function __construct(Request $request, AddressServiceImpl $addressService)
    {
        parent::__construct($request);
        $this->addressService = $addressService;
    }

    /**
     * 添加
     * @param EditAddressRequest $editAddressRequest
     * @return JsonResponse
     */
    public function add(EditAddressRequest $editAddressRequest): JsonResponse
    {
        $editAddressRequest->get('status') == 'true'?$status = 0: $status = 1;
        $this->addressService->add([
            'user_id' => $editAddressRequest->attributes->get('userId'),
            'name' => $editAddressRequest->get('name'),
            'phone' => $editAddressRequest->get('phone'),
            'province' => $editAddressRequest->get('province'),
            'city' => $editAddressRequest->get('city'),
            'area' => $editAddressRequest->get('area'),
            'detailed_address' => $editAddressRequest->get('detailedAddress'),
            'status' => $status
        ]);
        return AjaxResult::success();
    }

    /**
     * 编辑
     * @param int $id
     * @param EditAddressRequest $editAddressRequest
     * @return JsonResponse
     */
    public function edit(int $id, EditAddressRequest $editAddressRequest): JsonResponse
    {
        $editAddressRequest->get('status') == 'true'?$status = 0: $status = 1;
        $this->addressService->update($id,[
            'user_id' => $editAddressRequest->attributes->get('userId'),
            'name' => $editAddressRequest->get('name'),
            'phone' => $editAddressRequest->get('phone'),
            'province' => $editAddressRequest->get('province'),
            'city' => $editAddressRequest->get('city'),
            'area' => $editAddressRequest->get('area'),
            'detailed_address' => $editAddressRequest->get('detailedAddress'),
            'status' => $status
        ]);
        return AjaxResult::success();
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        return AjaxResult::successData(
            $this->addressService->listview($this->request->attributes->get('userId'))
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
            $this->addressService->show($id)
        );
    }

    /**
     * 删除
     * @param int $id
     * @return JsonResponse
     */
    public function del(int $id): JsonResponse
    {
        $this->addressService->del($id);
        return AjaxResult::success();
    }
}
