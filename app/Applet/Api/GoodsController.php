<?php

namespace App\Applet\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Service\Impl\GoodsServiceImpl as AdminGoodsServiceImpl;
use App\Admin\Service\IGoodsService as IAdminGoodsService;
use App\Core\Api\ApiController;
use App\Core\Exception\ParametersException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 商品控制器
 */
class GoodsController extends ApiController
{

    /**
     * @var IAdminGoodsService
     */
    private IAdminGoodsService $goodsService;

    /**
     * @param AdminGoodsServiceImpl $goodsService
     * @param Request $request
     */
    public function __construct(AdminGoodsServiceImpl $goodsService, Request $request)
    {
        $this->goodsService = $goodsService;
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
            $this->goodsService->listview([
                'classifyId' => $this->request->get('classifyId')
            ])
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
            $this->goodsService->show($id)
        );
    }

}
