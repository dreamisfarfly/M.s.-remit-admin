<?php

namespace App\Admin\Service\Impl;

use App\Admin\Request\UserQueryRequest;
use App\Admin\Service\IUserService;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * 用户服务层实现
 */
class UserServiceImpl implements IUserService
{

    /**
     * 用户列表
     * @param UserQueryRequest $userQueryRequest
     * @return LengthAwarePaginator
     */
    function listview(UserQueryRequest $userQueryRequest): LengthAwarePaginator
    {
        return User::adminGetUserInfoList([]);
    }
}
