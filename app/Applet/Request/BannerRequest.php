<?php

namespace App\Applet\Request;

use App\Core\Request\BaseRequest;

/**
 * 横幅请求
 */
class BannerRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'in:0,1,2'
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
