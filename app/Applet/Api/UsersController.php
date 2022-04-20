<?php

namespace App\Applet\Api;

use App\Applet\Request\LoginRequest;
use App\Applet\Service\Impl\UserServiceImpl;
use App\Applet\Service\IUserService;
use App\Core\Api\ApiController;
use App\Core\Domain\AjaxResult;
use App\Core\Exception\ParametersException;
use App\Core\Service\TokenService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 用户控制器
 */
class UsersController extends ApiController
{

    /**
     * @var IUserService
     */
    protected IUserService $userService;

    /**
     * @param UserServiceImpl $userService
     * @param Request $request
     */
    public function __construct(UserServiceImpl $userService, Request $request)
    {
        $this->userService = $userService;
        parent::__construct($request);
    }


    /**
     * 用户登录
     *
     * @param LoginRequest $loginRequest
     * @return JsonResponse
     * @throws ParametersException
     */
    public function login(LoginRequest $loginRequest): JsonResponse
    {
        return AjaxResult::successData((object)[
            'token' => $this->userService->login(
                $loginRequest->get('code'),
                $loginRequest->get('avatarUrl'),
                $loginRequest->get('nickName')
            )
        ]);
    }

    /**
     * 用户信息
     *
     * @return JsonResponse
     */
    public function userinfo(): JsonResponse
    {
        return AjaxResult::successData(
            $this->userService->userinfo($this->request->attributes->get('userId'))
        );
    }

}
