<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Request\ChangeBannerStateRequest;
use App\Admin\Request\EditBannerRequest;
use App\Admin\Service\IBannerService;
use App\Admin\Service\Impl\BannerServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 轮播图片
 */
class BannerController extends AdminController
{

    /**
     * @var IBannerService|BannerServiceImpl
     */
    protected IBannerService $bannerService;

    /**
     * @param Request $request
     * @param BannerServiceImpl $bannerService
     */
    public function __construct(Request $request, BannerServiceImpl $bannerService)
    {
        parent::__construct($request);
        $this->bannerService = $bannerService;
    }

    /**
     * 横幅列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        return AjaxResult::successData(
            $this->bannerService->listview($this->request)
        );
    }

    /**
     * 更改状态
     * @param int $id
     * @param ChangeBannerStateRequest $bannerStateRequest
     * @return JsonResponse
     */
    public function changeState(int $id, ChangeBannerStateRequest $bannerStateRequest): JsonResponse
    {
        $this->bannerService->changeState($id, $bannerStateRequest->get('status'));
        return AjaxResult::success();
    }

    /**
     * 更新轮播图片
     * @param EditBannerRequest $editBannerRequest
     * @return JsonResponse
     */
    public function append(EditBannerRequest $editBannerRequest): JsonResponse
    {
        $this->bannerService->append([
            'title' => $editBannerRequest->get('title'),
            'location' => $editBannerRequest->get('imageUrl'),
            'type' => $editBannerRequest->get('type'),
            'status' => $editBannerRequest->get('status'),
            'weight' => $editBannerRequest->get('weight')
        ]);
        return AjaxResult::success();
    }

    /**
     * 删除
     * @param int $id
     * @return JsonResponse
     */
    public function del(int $id): JsonResponse
    {
        $this->bannerService->delBanner($id);
        return AjaxResult::success();
    }

    /**
     * 详情
     * @param $id
     * @return JsonResponse
     */
    public function details($id): JsonResponse
    {
        return AjaxResult::successData(
            $this->bannerService->details($id)
        );
    }

    /**
     * 更新
     * @param int $id
     * @param EditBannerRequest $editBannerRequest
     * @return JsonResponse
     */
    public function update(int $id, EditBannerRequest $editBannerRequest): JsonResponse
    {
        $this->bannerService->update($id,[
            'title' => $editBannerRequest->get('title'),
            'location' => $editBannerRequest->get('imageUrl'),
            'type' => $editBannerRequest->get('type'),
            'status' => $editBannerRequest->get('status'),
            'weight' => $editBannerRequest->get('weight')
        ]);
        return AjaxResult::success();
    }

}
