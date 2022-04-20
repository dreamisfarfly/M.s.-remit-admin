<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Service\Impl\SysMenuServiceImpl;
use App\Admin\Service\ISysMenuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 后台菜单控制器
 */
class SysMenuController extends AdminController
{

    /**
     * @var ISysMenuService|SysMenuServiceImpl
     */
    protected ISysMenuService $sysMenuService;

    /**
     * @param Request $request
     * @param SysMenuServiceImpl $sysMenuService
     */
    public function __construct(Request $request, SysMenuServiceImpl $sysMenuService)
    {
        parent::__construct($request);
        $this->sysMenuService = $sysMenuService;
    }

    /**
     * 用户操作菜单
     * @return JsonResponse
     */
    public function getRouters(): JsonResponse
    {
        return AjaxResult::successData(
            $this->sysMenuService->selectMenuTreeByUserId($this->request->attributes->get('userId'))
        );
    }

}
