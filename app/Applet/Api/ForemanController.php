<?php

namespace App\Applet\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Applet\Service\IForemanService;
use App\Applet\Service\Impl\ForemanServiceImpl;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * 工长
 */
class ForemanController extends Controller
{

    /**
     * @var IForemanService
     */
    protected IForemanService $foremanService;

    /**
     * @param ForemanServiceImpl $foremanService
     */
    public function __construct(ForemanServiceImpl $foremanService)
    {
        $this->foremanService = $foremanService;
    }

    /**
     * 工长列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        return AjaxResult::successData(
            $this->foremanService->listview()
        );
    }

}
