<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 用户查询请求
 */
class UserQueryRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [

        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [

        ];
    }

}
