<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 更新分类状态请求
 */
class ChangeClassifyStateRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'in:0,1'
            ],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'status.required' => '状态不能为空',
            'status.in' => '状态范围不正确'
        ];
    }

}
