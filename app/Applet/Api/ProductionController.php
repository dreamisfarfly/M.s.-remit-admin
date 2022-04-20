<?php

namespace App\Applet\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\AdminCore\Exception\ParametersException;
use App\Admin\Service\Impl\ProductionServiceImpl as AdminProductionServiceImpl;
use App\Admin\Service\IProductionService as IAdminProductionService;
use App\Core\Api\ApiController;
use App\Models\Production;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 作品控制器
 */
class ProductionController extends ApiController
{

    /**
     * @var IAdminProductionService|AdminProductionServiceImpl
     */
    protected IAdminProductionService $adminProductionService;

    /**
     * @param Request $request
     * @param AdminProductionServiceImpl $adminProductionService
     */
    public function __construct(Request $request, AdminProductionServiceImpl $adminProductionService)
    {
        $this->adminProductionService = $adminProductionService;
        parent::__construct($request);
    }

    /**
     * 列表
     * @return JsonResponse
     * @throws ParametersException
     */
    public function listview(): JsonResponse
    {
        if(!$this->request->exists('classifyId') || $this->request->get('classifyId') == '')
        {
            throw new ParametersException('分类编号不能为空');
        }
        return AjaxResult::successData(
            $this->adminProductionService->listview(['classifyId'=>$this->request->get('classifyId')])
        );
    }

    /**
     * 设计师作品列表
     * @param int $designerId
     * @return JsonResponse
     */
    public function designerListView(int $designerId): JsonResponse
    {
        return AjaxResult::successData(
            $this->adminProductionService->listview(['designerId'=>$designerId])
        );
    }

    /**
     * 详情
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        Production::query()->where('id',$id)->increment('browse_number');
        return AjaxResult::successData(
            $this->adminProductionService->show($id)
        );
    }

}
