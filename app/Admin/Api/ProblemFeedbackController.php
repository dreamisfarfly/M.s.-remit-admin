<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Request\EditProblemFeedbackRequest;
use App\Admin\Request\ProblemFeedbackStatusRequest;
use App\Admin\Service\Impl\ProblemFeedbackServiceImpl;
use App\Admin\Service\IProblemFeedbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 反馈问题控制器
 */
class ProblemFeedbackController extends AdminController
{

    /**
     * @var IProblemFeedbackService|ProblemFeedbackServiceImpl
     */
    protected IProblemFeedbackService $problemFeedbackService;

    /**
     * @param Request $request
     * @param ProblemFeedbackServiceImpl $problemFeedbackServiceImpl
     */
    public function __construct(Request $request, ProblemFeedbackServiceImpl $problemFeedbackServiceImpl)
    {
        parent::__construct($request);
        $this->problemFeedbackService = $problemFeedbackServiceImpl;
    }

    /**
     * 反馈问题列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        $queryPram = [];
        $request = $this->request;
        if($request->exists('title') && $request->get('title') != '')
        {
            $queryPram['title'] = $request->get('title');
        }
        if($request->exists('status') && $request->get('status') != '')
        {
            $queryPram['status'] = $request->get('status');
        }
        return AjaxResult::successData(
            $this->problemFeedbackService->listview($queryPram)
        );
    }

    /**
     * 删除反馈问题
     * @param int $id
     * @return JsonResponse
     */
    public function del(int $id): JsonResponse
    {
        $this->problemFeedbackService->delete($id);
        return AjaxResult::success();
    }

    /**
     * 更新状态
     * @param int $id
     * @param ProblemFeedbackStatusRequest $problemFeedbackStatusRequest
     * @return JsonResponse
     */
    public function updateStatus(int $id,ProblemFeedbackStatusRequest $problemFeedbackStatusRequest): JsonResponse
    {
        $this->problemFeedbackService->update($id,['status'=>$problemFeedbackStatusRequest->get('status')]);
        return AjaxResult::success();
    }

    /**
     * 编辑
     * @param int $id
     * @param EditProblemFeedbackRequest $editProblemFeedbackRequest
     * @return JsonResponse
     */
    public function updated(int $id, EditProblemFeedbackRequest $editProblemFeedbackRequest): JsonResponse
    {
        $this->problemFeedbackService->update($id,[
            'title' => $editProblemFeedbackRequest->get('title'),
            'status' => $editProblemFeedbackRequest->get('status'),
            'weight' => $editProblemFeedbackRequest->get('weight'),
            'problem' => $editProblemFeedbackRequest->get('problem')
        ]);
        return AjaxResult::success();
    }

    /**
     * 新增
     * @param EditProblemFeedbackRequest $editProblemFeedbackRequest
     * @return JsonResponse
     */
    public function add(EditProblemFeedbackRequest $editProblemFeedbackRequest): JsonResponse
    {
        $this->problemFeedbackService->insert([
            'title' => $editProblemFeedbackRequest->get('title'),
            'status' => $editProblemFeedbackRequest->get('status'),
            'weight' => $editProblemFeedbackRequest->get('weight'),
            'problem' => $editProblemFeedbackRequest->get('problem')
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
            $this->problemFeedbackService->show($id)
        );
    }
}
