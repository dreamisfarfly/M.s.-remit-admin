<?php

namespace App\Applet\Api;

use App\Applet\Service\IHotService;
use App\Applet\Service\Impl\HotServiceImpl;
use App\Core\Api\ApiController;
use App\Core\Domain\AjaxResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 热门推荐控制器
 */
class HotController extends ApiController
{

    /**
     * @var IHotService|HotServiceImpl
     */
    protected IHotService $hotService;

    /**
     * @param Request $request
     * @param HotServiceImpl $hotServiceImpl
     */
    public function __construct(Request $request, HotServiceImpl $hotServiceImpl)
    {
        parent::__construct($request);
        $this->hotService = $hotServiceImpl;
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        return AjaxResult::successData(
            $this->hotService->hot()
        );
    }

}
