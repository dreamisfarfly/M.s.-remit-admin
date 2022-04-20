<?php

namespace App\Core\Middleware;

use App\Core\Exception\JurisdictionException;
use App\Core\Exception\ParametersException;
use App\Core\Service\TokenService;
use Closure;
use Illuminate\Http\Request;

/**
 * 中间件验证token
 */
class AuthenticationToken
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
        if($token == null || $token == '')
            throw new JurisdictionException('没有访问权限');
        if (!TokenService::verifyToken($token))
            throw new JurisdictionException('没有访问权限');
        $userInfo = TokenService::parseToken($token);
        $request->attributes->set('userId',$userInfo);
        return $next($request);
    }

}
