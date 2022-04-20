<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 订单详情列表请求
 */
class OrderInfoListviewRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'orderId' => 'required',
            'type' => 'required',
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'orderId.required' => '订单编号不能为空',
            'type.required' => '订单类型不能为空',
        ];
    }

}
