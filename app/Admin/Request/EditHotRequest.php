<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 编辑热门推荐
 */
class EditHotRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'imageUrl' => 'required',
            'goodsId' => 'required',
            'type' => 'required',
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
            'imageUrl.required' => '封面图不能为空',
            'goodsId.required' => '商品编号不能为空',
            'type.required' => '类型不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态范围不正确'
        ];
    }

}
