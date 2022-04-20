<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 分类类型请求
 */
class ClassifyTypeRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'in:0,1'
            ]
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'type.required' => '类型不能为空',
            'type.in' => '类型范围不正确'
        ];
    }

}
