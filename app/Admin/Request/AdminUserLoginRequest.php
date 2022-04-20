<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 管理员用户登录
 */
class AdminUserLoginRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'username.required' => '用户名不能为空',
            'password.required' => '密码不能为空'
        ];
    }

}
