<?php

namespace App\Applet\Request;

use App\Core\Request\BaseRequest;

/**
 * 分类请求
 */
class ClassifyRequest extends BaseRequest
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
            ],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'type.required' => '分类类型不能为空',
            'type.in' => '分类类型范围不正确'
        ];
    }

}
