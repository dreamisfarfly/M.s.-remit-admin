<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Request\EditDesignerRequest;
use App\Admin\Request\RecommendRequest;
use App\Admin\Request\ShowStatusRequest;
use App\Admin\Service\IDesignerService;
use App\Admin\Service\Impl\DesignerServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 设计师控制器
 */
class DesignerController extends AdminController
{

    /**
     * @var IDesignerService
     */
    protected IDesignerService $designerService;

    /**
     * @param Request $request
     * @param DesignerServiceImpl $designerService
     */
    public function __construct(Request $request, DesignerServiceImpl $designerService)
    {
        parent::__construct($request);
        $this->designerService = $designerService;
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        $queryParam = [];
        $request = $this->request;
        if($request->exists('nickname') && $request->get('nickname') != '')
        {
            $queryParam['nickname'] = $request->get('nickname');
        }
        if($request->exists('recommend') && $request->get('recommend') != '')
        {
            $queryParam['recommend'] = $request->get('recommend');
        }
        if($request->exists('status') && $request->get('status') != '')
        {
            $queryParam['status'] = $request->get('status');
        }
        return AjaxResult::successData(
            $this->designerService->listview($queryParam)
        );
    }

    /**
     * 删除
     * @param int $id
     * @return JsonResponse
     */
    public function del(int $id): JsonResponse
    {
        $this->designerService->del($id);
        return AjaxResult::success();
    }

    /**
     * 推荐状态
     * @param int $id
     * @param RecommendRequest $recommendRequest
     * @return JsonResponse
     */
    public function recommend(int $id, RecommendRequest $recommendRequest): JsonResponse
    {
        $this->designerService->update($id,[
            'is_recommend' => $recommendRequest->get('recommend')
        ]);
        return AjaxResult::success();
    }

    /**
     * 更改状态
     * @param int $id
     * @param ShowStatusRequest $showStatusRequest
     * @return JsonResponse
     */
    public function changeState(int $id, ShowStatusRequest $showStatusRequest): JsonResponse
    {
        $this->designerService->update($id,[
            'status' => $showStatusRequest->get('status')
        ]);
        return AjaxResult::success();
    }

    /**
     * 添加
     * @param EditDesignerRequest $editDesignerRequest
     * @return JsonResponse
     */
    public function add(EditDesignerRequest $editDesignerRequest): JsonResponse
    {
        $this->designerService->add([
            'nickname' => $editDesignerRequest->get('nickname'),
            'buddha' => $editDesignerRequest->get('buddha'),
            'experience' => $editDesignerRequest->get('experience'),
            'floor_price' => $editDesignerRequest->get('floorPrice'),
            'top_price' => $editDesignerRequest->get('topPrice'),
            'good_style' => json_encode($editDesignerRequest->get('goodStyle')),
            'status' => $editDesignerRequest->get('status'),
            'is_recommend' => $editDesignerRequest->get('recommend'),
            'individual_resume' => $editDesignerRequest->get('individualResume')
        ]);
        return AjaxResult::success();
    }

    /**
     * 更新
     * @param int $id
     * @param EditDesignerRequest $editDesignerRequest
     * @return JsonResponse
     */
    public function update(int $id, EditDesignerRequest $editDesignerRequest): JsonResponse
    {
        $this->designerService->update($id,[
            'nickname' => $editDesignerRequest->get('nickname'),
            'buddha' => $editDesignerRequest->get('buddha'),
            'experience' => $editDesignerRequest->get('experience'),
            'floor_price' => $editDesignerRequest->get('floorPrice'),
            'top_price' => $editDesignerRequest->get('topPrice'),
            'good_style' => json_encode($editDesignerRequest->get('goodStyle')),
            'status' => $editDesignerRequest->get('status'),
            'is_recommend' => $editDesignerRequest->get('recommend'),
            'individual_resume' => $editDesignerRequest->get('individualResume')
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
            $this->designerService->show($id)
        );
    }

    /**
     * 设计师列表
     * @return JsonResponse
     */
    public function designerListview(): JsonResponse
    {
        return AjaxResult::successData(
            $this->designerService->classifyListview()
        );
    }
}
