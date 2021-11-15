<?php

namespace App\Core\Middleware;

use App\Core\Exception\ParametersException;
use App\Core\Util\Jwt;
use Closure;

/**
 * 验证token
 */
class VerifyToken
{

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws ParametersException
     */
    public function handle($request, Closure $next)
    {

        $token = $request->header('Authorization');
        if (empty($token))
        {
            throw new ParametersException('token必须传递');
        }
        $decryption_character = Jwt::verifyToken($token);
        if ($decryption_character == false)
        {
            throw new ParametersException('token不正确');
        }
        if (!isset($decryption_character['user_id']))
        {
            throw new ParametersException('token不正确');
        }
        $request->attributes->set('user_id',$decryption_character['user_id']);
        return $next($request);
    }

}
