<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 编辑轮播图
 */
class EditBannerRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'imageUrl' => 'required',
            'status' => [
                'required',
                'in:0,1'
            ],
            'title' => 'required',
            'type' => [
                'required',
                'in:0,1,2'
            ],
            'weight' => [
                'required'
            ],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'imageUrl.required' => '轮播图片不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态范围不正确',
            'title.required' => '标题不能为空',
            'type.required' => '类型不能为空',
            'type.in' => '类型范围不正确',
            'weight.required' => '权重不能为空',
        ];
    }

}
