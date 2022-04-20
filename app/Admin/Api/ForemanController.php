<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Request\EditForemanRequest;
use App\Admin\Service\IForemanService;
use App\Admin\Service\Impl\ForemanServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 工长控制器
 */
class ForemanController extends AdminController
{

    /**
     * @var IForemanService
     */
    protected IForemanService $foremanService;

    /**
     * @param Request $request
     * @param ForemanServiceImpl $foremanServiceImpl
     */
    public function __construct(Request $request,ForemanServiceImpl $foremanServiceImpl)
    {
        parent::__construct($request);
        $this->foremanService = $foremanServiceImpl;
    }

    /**
     * 分类
     * @return JsonResponse
     */
    public function classify(): JsonResponse
    {
        return AjaxResult::successData($this->foremanService->classify());
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        $searchParam = [];
        $request = $this->request;
        if($request->exists('nickname') && $request->get('nickname') != '')
        {
            $searchParam['nickname'] = $request->get('nickname');
        }
        return AjaxResult::successData($this->foremanService->listview($searchParam));
    }

    /**
     * 删除
     * @param int $id
     * @return JsonResponse
     */
    public function del(int $id): JsonResponse
    {
        $this->foremanService->update($id,['is_del' => CommunalStatus::YES_DELETE]);
        return AjaxResult::success();
    }

    /**
     * 添加
     * @param EditForemanRequest $editForemanRequest
     * @return JsonResponse
     */
    public function add(EditForemanRequest $editForemanRequest): JsonResponse
    {
        $this->foremanService->add([
            'nickname' => $editForemanRequest->get('nickname'),
            'buddha' => $editForemanRequest->get('buddha'),
            'site_name' => $editForemanRequest->get('siteName'),
            'working_seniority' => $editForemanRequest->get('workingSeniority')
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
        return AjaxResult::successData($this->foremanService->show($id));
    }

    /**
     * 更新
     * @param int $id
     * @param EditForemanRequest $editForemanRequest
     * @return JsonResponse
     */
    public function update(int $id, EditForemanRequest $editForemanRequest): JsonResponse
    {
        $this->foremanService->update($id,[
            'nickname' => $editForemanRequest->get('nickname'),
            'buddha' => $editForemanRequest->get('buddha'),
            'site_name' => $editForemanRequest->get('siteName'),
            'working_seniority' => $editForemanRequest->get('workingSeniority')
        ]);
        return AjaxResult::success();
    }

}
