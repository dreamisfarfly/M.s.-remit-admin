<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\Request\UserQueryRequest;
use App\Admin\Service\Impl\UserServiceImpl;
use App\Admin\Service\IUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 用户控制器
 */
class UserController extends AdminController
{

    /**
     * @var IUserService|UserServiceImpl
     */
    protected IUserService $userService;

    /**
     * @param Request $request
     * @param UserServiceImpl $serviceImpl
     */
    public function __construct(Request $request, UserServiceImpl $serviceImpl)
    {
        parent::__construct($request);
        $this->userService = $serviceImpl;
    }

    /**
     * 用户列表
     * @param UserQueryRequest $userQueryRequest
     * @return JsonResponse
     */
    public function listview(UserQueryRequest $userQueryRequest): JsonResponse
    {
        return  AjaxResult::successData(
            $this->userService->listview($userQueryRequest)
        );
    }

}
