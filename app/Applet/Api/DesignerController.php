<?php

namespace App\Applet\Api;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Service\IDesignerService as IAdminDesignerService;
use App\Admin\Service\Impl\DesignerServiceImpl as AdminDesignerServiceImpl;
use App\Applet\Service\IDesignerService;
use App\Applet\Service\Impl\DesignerServiceImpl;
use App\Http\Controllers\Controller;
use App\Models\Designer;
use App\Models\Goods;
use Illuminate\Http\JsonResponse;

/**
 * 设计师
 */
class DesignerController extends Controller
{

    /**
     * @var IAdminDesignerService
     */
    protected IAdminDesignerService $adminDesignerService;

    /**
     * @var IDesignerService
     */
    protected IDesignerService $designerService;

    /**
     * @param AdminDesignerServiceImpl $adminDesignerService
     * @param DesignerServiceImpl $designerService
     */
    public function __construct(AdminDesignerServiceImpl $adminDesignerService, DesignerServiceImpl $designerService)
    {
        $this->adminDesignerService = $adminDesignerService;
        $this->designerService = $designerService;
    }

    /**
     * 优秀设计师
     * @return JsonResponse
     */
    public function excellentDesigner(): JsonResponse
    {
        return AjaxResult::successData(
            $this->designerService->excellentDesigner()
        );
    }

    /**
     * 设计师列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        return AjaxResult::successData(
            $this->adminDesignerService->listview(['status' => CommunalStatus::SHOW])
        );
    }

    /**
     * 设计师详情
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return AjaxResult::successData(
            $this->adminDesignerService->show($id)
        );
    }

}
