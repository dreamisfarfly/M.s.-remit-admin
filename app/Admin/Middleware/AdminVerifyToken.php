<?php

namespace App\Admin\Middleware;

use App\Admin\AdminCore\Config\Configuration;
use App\Admin\AdminCore\Exception\JurisdictionException;
use App\Admin\AdminCore\Exception\ParametersException;
use App\Admin\AdminCore\Service\TokenService;
use Closure;
use Illuminate\Http\Request;

/**
 * 后台验证token，权限中间件
 */
class AdminVerifyToken
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws JurisdictionException
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        $tokenService = new TokenService(Configuration::SING,Configuration::EXPIRE,Configuration::ISSUER);
        if($token == null || $token == '')
            throw new JurisdictionException('无权限');
        if (!$tokenService->verifyToken($token))
            throw new JurisdictionException('无权限');
        $userInfo = $tokenService->parseToken($token);
        $request->attributes->set('userId',$userInfo);
        return $next($request);
    }

}
