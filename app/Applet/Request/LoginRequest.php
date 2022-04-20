<?php

namespace App\Applet\Request;

use App\Core\Request\BaseRequest;

/**
 * 用户登录请求
 */
class LoginRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'code' => 'required',
            'avatarUrl' => 'required',
            'nickName' => 'required'
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'code.required' => 'code不能为空',
            'avatarUrl.required' => '微信头像不能为空',
            'nickName.required' => '微信名称不能为空'
        ];
    }

}
