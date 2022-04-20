<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Request\EditCaseRequest;
use App\Admin\Service\ICaseService;
use App\Admin\Service\Impl\CaseServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 案例
 */
class CaseController extends AdminController
{

    /**
     * @var ICaseService
     */
    protected ICaseService $caseService;

    /**
     * @param Request $request
     * @param CaseServiceImpl $caseService
     */
    public function __construct(Request $request, CaseServiceImpl $caseService)
    {
        parent::__construct($request);
        $this->caseService = $caseService;
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
        return AjaxResult::successData(
            $this->caseService->listview($searchParam)
        );
    }

    /**
     * 删除案例
     * @param int $id
     * @return JsonResponse
     */
    public function del(int $id): JsonResponse
    {
        $this->caseService->update($id,['is_del' => CommunalStatus::YES_DELETE]);
        return AjaxResult::success();
    }

    /**
     * 详情
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return AjaxResult::successData($this->caseService->show($id));
    }


    /**
     * 更新
     * @param int $id
     * @param EditCaseRequest $editCaseRequest
     * @return JsonResponse
     */
    public function edit(int $id, EditCaseRequest $editCaseRequest): JsonResponse
    {
        $this->caseService->update($id,[
            'foreman_id' => $editCaseRequest->get('foremanId'),
            'title' => $editCaseRequest->get('title'),
            'surface_plot' => $editCaseRequest->get('surfacePlot'),
            'status' => $editCaseRequest->get('status'),
            'detail' => $editCaseRequest->get('detail')
        ]);
        return AjaxResult::success();
    }

    /**
     * 添加
     * @param EditCaseRequest $editCaseRequest
     * @return JsonResponse
     */
    public function add(EditCaseRequest $editCaseRequest): JsonResponse
    {
        $this->caseService->add([
            'foreman_id' => $editCaseRequest->get('foremanId'),
            'title' => $editCaseRequest->get('title'),
            'surface_plot' => $editCaseRequest->get('surfacePlot'),
            'status' => $editCaseRequest->get('status'),
            'detail' => $editCaseRequest->get('detail')
        ]);
        return AjaxResult::success();
    }

}
