<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Request\EditHotRequest;
use App\Admin\Service\IHotService;
use App\Admin\Service\Impl\HotServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 热门推荐控制器
 */
class HotController extends AdminController
{

    /**
     * @var IHotService|HotServiceImpl
     */
    protected IHotService $hotService;

    /**
     * @param Request $request
     * @param HotServiceImpl $hotServiceImpl
     */
    public function __construct(Request $request, HotServiceImpl $hotServiceImpl)
    {
        parent::__construct($request);
        $this->hotService = $hotServiceImpl;
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        $queryParam = [];
        if($this->request->exists('type') && $this->request->get('type') != '')
        {
            $queryParam['type'] = $this->request->get('type');
        }
        return AjaxResult::successData(
            $this->hotService->listview($queryParam)
        );
    }

    /**
     * 添加
     * @param EditHotRequest $editHotRequest
     * @return JsonResponse
     */
    public function add(EditHotRequest $editHotRequest): JsonResponse
    {
        $this->hotService->add([
            'goods_id' => $editHotRequest->get('goodsId'),
            'surface_plot' => $editHotRequest->get('imageUrl'),
            'type' => $editHotRequest->get('type'),
            'status' => $editHotRequest->get('status')
        ]);
        return AjaxResult::success();
    }

    /**
     * 更新
     * @param int $id
     * @param EditHotRequest $editHotRequest
     * @return JsonResponse
     */
    public function update(int $id, EditHotRequest $editHotRequest): JsonResponse
    {
        $this->hotService->updated($id,[
            'goods_id' => $editHotRequest->get('goodsId'),
            'surface_plot' => $editHotRequest->get('imageUrl'),
            'type' => $editHotRequest->get('type'),
            'status' => $editHotRequest->get('status')
        ]);
        return AjaxResult::success();
    }

    /**
     * 详情
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return AjaxResult::successData(
            $this->hotService->show($id)
        );
    }

    /**
     * 删除
     * @param int $id
     * @return JsonResponse
     */
    public function del(int $id): JsonResponse
    {
        $this->hotService->del($id);
        return AjaxResult::success();
    }

}
