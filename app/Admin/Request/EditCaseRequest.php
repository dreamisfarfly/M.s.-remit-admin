<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 编辑案例请求
 */
class EditCaseRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'surfacePlot' => 'required',
            'foremanId' => 'required',
            'status' => [
                'required',
                'in:0,1'
            ],
            'detail' => 'required'
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'title.required' => '标题不能为空',
            'surfacePlot.required' => '封面图不能为空',
            'foremanId.required' => '工长不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态范围不正确',
            'detail.required' => '详情不能为空'
        ];
    }

}
