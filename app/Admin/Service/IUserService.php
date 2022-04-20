<?php

namespace App\Admin\Service;

use App\Admin\Request\UserQueryRequest;

/**
 * 用户服务层接口
 */
interface IUserService
{

    /**
     * 用户列表
     * @param UserQueryRequest $userQueryRequest
     * @return mixed
     */
    function listview(UserQueryRequest $userQueryRequest);

}
