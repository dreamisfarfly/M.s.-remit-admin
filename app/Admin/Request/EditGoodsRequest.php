<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;
use App\Admin\AdminCore\Validators\VerifyArray;

/**
 * 编辑商品请求
 */
class EditGoodsRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'type' => [
                'required',
                'in:0,1,2'
            ],
            'classifyId' => 'required',
            'surfacePlot' => 'required',
            'banner' => [
                'required',
                new VerifyArray()
            ],
            'price' => [
                'required'
            ],
            'inventory' => [
                'required'
            ],
            'details' => 'required',
            'commonProblem' => 'required',
            'status' => [
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
            'title.required' => '标题不能为空',
            'type.required' => '类型不能为空',
            'type.in' => '类型范围不正确',
            'surfacePlot.required' => '封面图不能为空',
            'classifyId.required' => '类型不能为空',
            'price.required' => '价格不能为空',
            'inventory.required' => '库存不能为空',
            'details.required' => '详情不能为空',
            'commonProblem.required' => '问题描述不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态范围不正确',
        ];
    }

}
