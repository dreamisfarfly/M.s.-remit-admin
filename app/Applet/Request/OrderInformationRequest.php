<?php

namespace App\Applet\Request;

use App\Core\Request\BaseRequest;

/**
 * 订单信息
 */
class OrderInformationRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'type' => 'required',
            'id' => 'required',
            'count' => 'required'
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'type.required' => '商品类型不能为空',
            'id.required' => '商品编号不能为空',
            'count.required' => '数量不能为空',
        ];
    }

}
