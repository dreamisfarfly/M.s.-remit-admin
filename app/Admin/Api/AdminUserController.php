<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\AdminCore\Exception\ParametersException;
use App\Admin\Request\AdminUserLoginRequest;
use App\Admin\Service\Impl\SysUserServiceImpl;
use App\Admin\Service\ISysUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 后台用户控制器
 */
class AdminUserController extends AdminController
{

    /**
     * @var ISysUserService
     */
    private ISysUserService $userService;

    /**
     * @param Request $request
     * @param SysUserServiceImpl $serviceImpl
     */
    public function __construct(Request $request, SysUserServiceImpl $serviceImpl)
    {
        $this->userService = $serviceImpl;
        parent::__construct($request);
    }

    /**
     * 登录
     * @param AdminUserLoginRequest $adminUserLoginRequest
     * @return JsonResponse
     * @throws ParametersException
     */
    public function login(AdminUserLoginRequest $adminUserLoginRequest): JsonResponse
    {
        return AjaxResult::successData((object)
             $this->userService->login(
                $adminUserLoginRequest->get('username'),
                $adminUserLoginRequest->get('password')
             )
        );
    }

    /**
     * 用户信息
     * @return JsonResponse
     */
    public function info(): JsonResponse
    {
        return AjaxResult::successData(
            $this->userService->userinfo($this->request->attributes->get('userId'))
        );
    }

    /**
     * 退出登录
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        return AjaxResult::success();
    }

}
