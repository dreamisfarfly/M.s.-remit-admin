<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Request\EditProductionRequest;
use App\Admin\Service\Impl\ProblemFeedbackServiceImpl;
use App\Admin\Service\Impl\ProductionServiceImpl;
use App\Admin\Service\IProductionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 作品控制器
 */
class ProductionController extends AdminController
{

    /**
     * @var IProductionService
     */
    protected IProductionService $productionService;

    /**
     * @param Request $request
     * @param ProductionServiceImpl $productionService
     */
    public function __construct(Request $request, ProductionServiceImpl $productionService)
    {
        parent::__construct($request);
        $this->productionService = $productionService;
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        $searchParam = [];
        $request = $this->request;
        if($request->exists('title') && $request->get('title') != '')
        {
            $searchParam['title'] = $request->get('title');
        }
        if($request->exists('classifyId') && $request->get('classifyId') != '')
        {
            $searchParam['classifyId'] = $request->get('classifyId');
        }
        return AjaxResult::successData(
            $this->productionService->listview($searchParam)
        );
    }

    /**
     * 删除
     * @param int $id
     * @return JsonResponse
     */
    public function del(int $id): JsonResponse
    {
        $this->productionService->updated($id,['is_del'=>CommunalStatus::YES_DELETE]);
        return AjaxResult::success();
    }

    /**
     * 添加
     * @param EditProductionRequest $editProductionRequest
     * @return JsonResponse
     */
    public function add(EditProductionRequest $editProductionRequest): JsonResponse
    {
        $this->productionService->add([
            'classify_id' => $editProductionRequest->get('classifyId'),
            'designer_id' => $editProductionRequest->get('designerId'),
            'surface_plot' => $editProductionRequest->get('surfacePlot'),
            'title' => $editProductionRequest->get('title'),
            'browse_number' => $editProductionRequest->get('browseNumber'),
            'genre' => $editProductionRequest->get('genre'),
            'details' => $editProductionRequest->get('details')
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
            $this->productionService->show($id)
        );
    }

    /**
     * 编辑
     * @param int $id
     * @param EditProductionRequest $editProductionRequest
     * @return JsonResponse
     */
    public function edit(int $id, EditProductionRequest $editProductionRequest): JsonResponse
    {
        $this->productionService->updated($id,[
            'classify_id' => $editProductionRequest->get('classifyId'),
            'designer_id' => $editProductionRequest->get('designerId'),
            'surface_plot' => $editProductionRequest->get('surfacePlot'),
            'title' => $editProductionRequest->get('title'),
            'browse_number' => $editProductionRequest->get('browseNumber'),
            'genre' => $editProductionRequest->get('genre'),
            'details' => $editProductionRequest->get('details')
        ]);
        return AjaxResult::success();
    }

}
