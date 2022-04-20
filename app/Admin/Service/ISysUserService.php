<?php

namespace App\Admin\Service;

/**
 * 后台用户服务层
 */
interface ISysUserService
{

    /**
     * 后台登录
     * @param string $username 用户名
     * @param string $password 用户密码
     * @return mixed 结果
     */
    function login(string $username, string $password);

    /**
     * 用户信息
     * @param int $id
     * @return mixed
     */
    function userinfo(int $id);

}
