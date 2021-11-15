<?php


namespace App\Core\Util;

/**
 * JWT
 * Class Jwt
 * @package App\Core\Util
 */
class Jwt
{

    //頭部
    protected static array $header = [
        'alg' => 'H5256', //生成signature的算法
        'typ' => 'JWT', //類型
    ];

    //使用HMAC生成信息摘要時所使用的密鑰
    protected static string $key = 'xcl6868';

    /**
     * 獲取jwt token
     * @param array $payload jwt載荷 格式如下為非必須
     * [
     *    'iss' => 'jwt_admin' //該jwt的簽發這
     *    ‘iat’ => time(), //簽發時間
     *    'exp' => time()+7200, //過期時間
     *    'nbf' => time()+60, //該時間之前不接收處理該Token
     *    'sub' => 'www.admin.com', //面向的用戶
     *    'jti' => md5(uniqid('JWT').time) //該Token唯一表識
     * ]
     * @return false|string
     */
    public static function getToken(array $payload)
    {
        if (is_array($payload))
        {
            $base64header = self::base64UrlEncode(json_encode(self::$header,JSON_UNESCAPED_UNICODE));
            $base64payload = self::base64UrlEncode(json_encode($payload,JSON_UNESCAPED_UNICODE));
            return $base64header.'.'.$base64payload.'.'.self::signature($base64header.'.'.$base64payload,self::$key,self::$header['alg']);
        }else{
            return false;
        }
    }

    /**
     * 驗證token是否有效，，默認驗證exp,nbf,iat時間
     * @param string $token
     * @return false|mixed
     */
    public static function verifyToken(string $token)
    {
        $tokens = explode('.', $token);
        if (count($tokens) != 3)
        {
            return false;
        }

        list($base64header,$base64payload,$sign) = $tokens;

        //獲取jwt算法
        $base64decodeheader = json_decode(self::base64UrlDecode($base64header), JSON_OBJECT_AS_ARRAY);
        if (empty($base64decodeheader['alg']))
            return false;

        //簽名驗證
        if (self::signature($base64header.'.'.$base64payload,self::$key,$base64decodeheader['alg']) != $sign)
            return false;

        $payload = json_decode(self::base64UrlDecode($base64payload),JSON_OBJECT_AS_ARRAY);

        //簽發時間大於單簽服務器時間驗證失敗
        if (isset($payload['iat']) && $payload['iat'] > time())
            return false;

        //過期時間小於單簽服務器時間驗證失敗
        if (isset($payload['exp']) && $payload['exp'] < time())
            return false;

        //該nbf時間之前不接收處理該token
        if (isset($payload['nbf']) && $payload['nbf'] > time())
            return false;

        return $payload;
    }

    /**
     * base64UrlEncode
     * @param string $input     需要編碼的字符串
     * @return string|string[]
     */
    private static function base64UrlEncode(string $input)
    {
        return str_replace('=','',strtr(base64_encode($input),'+/','-_'));
    }

    /**
     * base64UrlEncode
     * @param String $input   需要解碼的字符串
     * @return false|string
     */
    private static function base64UrlDecode(String $input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder)
        {
            $addLen = 4 - $remainder;
            $input .= str_repeat('=',$addLen);
        }
        return base64_decode(strtr($input,'-_','+/'));
    }

    /**
     * HMACSHA256簽名
     * @param string $input
     * @param string $key
     * @param string $alg 算法方式
     * @return string|string[]
     */
    private static function signature(string $input, string $key, string $alg = 'H5256')
    {
        $alg_config = [
            'H5256' => 'sha256'
        ];
        return self::base64UrlEncode(hash_hmac($alg_config[$alg],$input,$key,true));
    }

}
