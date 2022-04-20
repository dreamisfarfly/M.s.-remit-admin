<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Request\EditGoodsRequest;
use App\Admin\Service\IGoodsService;
use App\Admin\Service\Impl\GoodsServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 商品控制器
 */
class GoodsController extends AdminController
{

    /**
     * @var IGoodsService
     */
    protected IGoodsService $goodsService;

    /**
     * @param Request $request
     * @param GoodsServiceImpl $goodsService
     */
    public function __construct(Request $request, GoodsServiceImpl $goodsService)
    {
        parent::__construct($request);
        $this->goodsService = $goodsService;
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        $searchParam = [];
        $request = $this->request;
        if($request->exists('classifyId') && $request->get('classifyId') != '')
        {
            $searchParam['classifyId'] = $request->get('classifyId');
        }
        if($request->exists('type') && $request->get('type') != '')
        {
            $searchParam['type'] = $request->get('type');
        }
        if($request->exists('title') && $request->get('title') != '')
        {
            $searchParam['title'] = $request->get('title');
        }
        return AjaxResult::successData($this->goodsService->listview($searchParam));
    }

    /**
     * 删除
     * @param int $id
     * @return JsonResponse
     */
    public function del(int $id): JsonResponse
    {
        $this->goodsService->update($id,['is_del'=>CommunalStatus::YES_DELETE]);
        return AjaxResult::success();
    }

    /**
     * 添加
     * @param EditGoodsRequest $editGoodsRequest
     * @return JsonResponse
     */
    public function add(EditGoodsRequest $editGoodsRequest): JsonResponse
    {
        $this->goodsService->add([
            'classify_id' => $editGoodsRequest->get('classifyId'),
            'type' => $editGoodsRequest->get('type'),
            'status' => $editGoodsRequest->get('status'),
            'banner' => json_encode($editGoodsRequest->get('banner')),
            'title' => $editGoodsRequest->get('title'),
            'surface_plot' => $editGoodsRequest->get('surfacePlot'),
            'price' => $editGoodsRequest->get('price'),
            'inventory' => $editGoodsRequest->get('inventory'),
            'details' => $editGoodsRequest->get('details'),
            'common_problem' => $editGoodsRequest->get('commonProblem')
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
            $this->goodsService->show($id)
        );
    }

    /**
     * 更新
     * @param int $id
     * @param EditGoodsRequest $editGoodsRequest
     * @return JsonResponse
     */
    public function edit(int $id, EditGoodsRequest $editGoodsRequest): JsonResponse
    {
        $this->goodsService->update($id,[
            'classify_id' => $editGoodsRequest->get('classifyId'),
            'type' => $editGoodsRequest->get('type'),
            'status' => $editGoodsRequest->get('status'),
            'banner' => $editGoodsRequest->get('banner'),
            'title' => $editGoodsRequest->get('title'),
            'surface_plot' => $editGoodsRequest->get('surfacePlot'),
            'price' => $editGoodsRequest->get('price'),
            'inventory' => $editGoodsRequest->get('inventory'),
            'details' => $editGoodsRequest->get('details'),
            'common_problem' => $editGoodsRequest->get('commonProblem')
        ]);
        return AjaxResult::success();
    }

    /**
     * 分类列表
     * @return JsonResponse
     */
    public function classifyListview(): JsonResponse
    {
        return AjaxResult::successData($this->goodsService->classifyListview());
    }

}
