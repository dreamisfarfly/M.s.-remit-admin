<?php

namespace App\Admin\Service\Impl;

use App\Admin\AdminCore\Config\Configuration;
use App\Admin\AdminCore\Exception\ParametersException;
use App\Admin\AdminCore\Service\TokenService;
use App\Admin\Models\SysUsers;
use App\Admin\Service\ISysUserService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 后台用户服务层
 */
class SysUserServiceImpl implements ISysUserService
{

    /**
     * 后台登录
     * @param string $username 用户名
     * @param string $password 用户密码
     * @return array 结果
     * @throws ParametersException
     */
    function login(string $username, string $password): array
    {
        $userInfo = SysUsers::login($username,$password);
        if($userInfo == null)
            throw new ParametersException('用户不存在或者密码错误');
        $tokenService = new TokenService(Configuration::SING,Configuration::EXPIRE,Configuration::ISSUER);
        return [
            'token' => $tokenService->createToken($userInfo->user_id),
            'nickname' => $userInfo->nick_name,
            'uuid' => $userInfo->id
        ];
    }

    /**
     * 用户信息
     * @param int $id
     * @return Builder|Model|object|null
     */
    function userinfo(int $id)
    {
        $userInfo = SysUsers::userinfo($id);
        if($userInfo != null)
        {
            $userInfo->avatar = config('filesystems.disks.file.url').$userInfo->avatar;
        }
        return $userInfo;
    }
}
