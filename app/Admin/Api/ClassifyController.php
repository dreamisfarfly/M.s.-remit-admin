<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Request\ChangeClassifyStateRequest;
use App\Admin\Request\ClassifyTypeRequest;
use App\Admin\Request\EditClassifyRequest;
use App\Admin\Service\IClassifyService;
use App\Admin\Service\Impl\ClassifyServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 分类控制器
 */
class ClassifyController extends AdminController
{

    /**
     * @var IClassifyService
     */
    protected IClassifyService $classifyService;

    /**
     * @param Request $request
     * @param ClassifyServiceImpl $classifyService
     */
    public function __construct(Request $request, ClassifyServiceImpl $classifyService)
    {
        parent::__construct($request);
        $this->classifyService = $classifyService;
    }

    /**
     * 分类列表
     * @param Request $request
     * @return JsonResponse
     */
    public function listview(Request $request): JsonResponse
    {
        return AjaxResult::successData(
            $this->classifyService->list($request)
        );
    }

    /**
     * 删除分类
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $this->classifyService->del($id);
        return AjaxResult::success();
    }

    /**
     * 更新状态
     * @param int $id
     * @param ChangeClassifyStateRequest $changeClassifyStateRequest
     * @return JsonResponse
     */
    public function changeState(int $id, ChangeClassifyStateRequest $changeClassifyStateRequest): JsonResponse
    {
        $this->classifyService->update($id,[
            'status' => $changeClassifyStateRequest->get('status')
        ]);
        return AjaxResult::success();
    }

    /**
     * 更新分类
     * @param int $id
     * @param EditClassifyRequest $editClassifyRequest
     * @return JsonResponse
     */
    public function update(int $id, EditClassifyRequest $editClassifyRequest): JsonResponse
    {
        $this->classifyService->update($id,[
            'title' => $editClassifyRequest->get('title'),
            'type' => $editClassifyRequest->get('type'),
            'status' => $editClassifyRequest->get('status'),
            'weight' => $editClassifyRequest->get('weight')
        ]);
        return AjaxResult::success();
    }

    /**
     * 新增分类
     * @param EditClassifyRequest $editClassifyRequest
     * @return JsonResponse
     */
    public function add(EditClassifyRequest $editClassifyRequest): JsonResponse
    {
        $this->classifyService->add([
            'title' => $editClassifyRequest->get('title'),
            'type' => $editClassifyRequest->get('type'),
            'status' => $editClassifyRequest->get('status'),
            'weight' => $editClassifyRequest->get('weight')
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
            $this->classifyService->show($id)
        );
    }

    /**
     * 分类
     * @param ClassifyTypeRequest $classifyTypeRequest
     * @return JsonResponse
     */
    public function classifyList(ClassifyTypeRequest $classifyTypeRequest): JsonResponse
    {
        return AjaxResult::successData(
            $this->classifyService->classifyList($classifyTypeRequest->get('type'))
        );
    }

}
