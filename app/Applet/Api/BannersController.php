<?php

namespace App\Applet\Api;

use App\Applet\Request\BannerRequest;
use App\Applet\Service\IBannersService;
use App\Applet\Service\Impl\BannersServiceImpl;
use App\Core\Domain\AjaxResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * 横幅控制器
 */
class BannersController extends Controller
{

    /**
     * @var IBannersService|BannersServiceImpl
     */
    protected IBannersService $bannersService;

    /**
     * @param BannersServiceImpl $bannersServiceImpl
     */
    public function __construct(BannersServiceImpl $bannersServiceImpl)
    {
        $this->bannersService = $bannersServiceImpl;
    }

    /**
     *横幅列表
     *
     * @param BannerRequest $bannerRequest
     * @return JsonResponse
     */
    public function listview(BannerRequest $bannerRequest): JsonResponse
    {
        return AjaxResult::successData(
            $this->bannersService->listview($bannerRequest->get('type'))
        );
    }

}
