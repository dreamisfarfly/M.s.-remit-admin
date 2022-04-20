<?php

namespace App\Applet\Request;

use App\Core\Request\BaseRequest;

/**
 * 地址编辑请求
 */
class EditAddressRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'city' => 'required',
            'area' => 'required',
            'detailedAddress' => 'required',
            'status' => [
                'required',
            ],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => '收货人姓名不能为空',
            'phone.required' => '手机号码不能为空',
            'province.required' => '省不能为空',
            'city.required' => '市不能为空',
            'area.required' => '区不能为空',
            'detailedAddress.required' => '详细地址不能为空',
            'status.required' => '状态不能为空',
        ];
    }

}
