<?php

namespace App\Applet\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 创建订单请求
 */
class CreateOrderRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
            'type' => [
                'required',
                'in:0,1'
            ],
            'count' => 'required',
            'addressId' => 'required',
            'deliveryTime' => 'required',
            'leaveWord' => 'required',
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'id.required' => '商品编号不能为空',
            'type.required' => '商品分类不能为空',
            'count.required' => '商品数量不能为空',
            'addressId.required' => '地址编号不能为空',
            'deliveryTime.required' => '送货时间不能为空',
            'leaveWord.required' => '买家留言不能为空'
        ];
    }

}
