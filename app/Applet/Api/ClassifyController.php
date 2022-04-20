<?php

namespace App\Applet\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Applet\Request\ClassifyRequest;
use App\Applet\Service\IClassifyService;
use App\Applet\Service\Impl\ClassifyServiceImpl;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * 分类控制器
 */
class ClassifyController extends Controller
{

    /**
     * @var IClassifyService
     */
    protected IClassifyService $goodsClassifyService;

    /**
     * @param ClassifyServiceImpl $classifyServiceImpl
     */
    public function __construct(ClassifyServiceImpl $classifyServiceImpl)
    {
        $this->goodsClassifyService = $classifyServiceImpl;
    }

    /**
     * 商品分类
     * @param ClassifyRequest $classifyRequest
     * @return JsonResponse
     */
    public function classify(ClassifyRequest $classifyRequest): JsonResponse
    {
        return AjaxResult::successData($this->goodsClassifyService->listview($classifyRequest->get('type')));
    }

}
