<?php

namespace App\Applet\Service;

/**
 * 用户服务接口
 */
interface IUserService
{

    /**
     * 用户登录
     * @param string $code 小程序登录code
     * @param string $avatarUrl 用户头像
     * @param string $nickname 用户昵称
     * @return mixed token
     */
    function login(string $code, string $avatarUrl, string $nickname);

    /**
     * 用户信息
     * @param int $id
     * @return mixed
     */
    function userinfo(int $id);

}
