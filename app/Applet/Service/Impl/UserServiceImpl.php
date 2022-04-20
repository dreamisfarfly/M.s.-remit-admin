<?php

namespace App\Applet\Service\Impl;

use App\Applet\Service\IUserService;
use App\Core\Exception\ParametersException;
use App\Core\Service\TokenService;
use App\Models\User;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * 用户服务接口实现
 */
class UserServiceImpl implements IUserService
{

    /**
     * 用户登录
     * @param string $code 小程序登录code
     * @param string $avatarUrl 用户头像
     * @param string $nickname 用户昵称
     * @return string token
     * @throws ParametersException
     */
    public function login(string $code, string $avatarUrl, string $nickname): string
    {
        $app = Factory::miniProgram(config('wechat.mini_program.default'));
        try{
            $result = $app->auth->session($code);
        }catch (InvalidConfigException $exception){
            throw new ParametersException('微信小程序配置错误');
        }
        if(!isset($result['openid']))
            throw new ParametersException('code不存在或者已失效');
        $userInfo = User::getUserInfoByOpen($result['openid']);
        if($userInfo == null) //用户没有登录过
        {
            $id = User::addUserGetId([
                'open_id' => $result['openid'],
                'avatar_url' => $avatarUrl,
                'nickname' => $nickname
            ]);
        }
        if($userInfo != null)
            $id = $userInfo->id;
        return TokenService::createToken($id);
    }

    /**
     * 用户信息
     * @param int $id
     * @return Builder|Model|object|null
     */
    function userinfo(int $id)
    {
        return User::getUserInfoById($id);
    }
}
