<?php

namespace App\Applet\Api;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Service\ICaseService as IAdminCaseService;
use App\Admin\Service\Impl\CaseServiceImpl as AdminCaseServiceImpl;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * 案例控制器
 */
class CaseController extends Controller
{

    /**
     * @var IAdminCaseService
     */
    protected IAdminCaseService $adminCaseService;

    public function __construct(AdminCaseServiceImpl $adminCaseService)
    {
        $this->adminCaseService = $adminCaseService;
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        return AjaxResult::successData(
            $this->adminCaseService->listview([])
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
            $this->adminCaseService->show($id)
        );
    }

}
