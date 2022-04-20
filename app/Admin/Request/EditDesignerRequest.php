<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 编辑设计师
 */
class EditDesignerRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'buddha' => 'required',
            'nickname' => 'required',
            'floorPrice' => [
                'required'
            ],
            'topPrice' => [
                'required'
            ],
            'experience' => [
                'required'
            ],
            'recommend' => [
                'required',
                'in:0,1'
            ],
            'status' => [
                'required',
                'in:0,1'
            ],
            'goodStyle' => [
                'required',
            ],
            'individualResume' => [
                'required',
            ]
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'buddha.required' => '头像不能为空',
            'nickname.required' => '昵称不能为空',
            'goodStyle.required' => '擅长风格不能为空',
            'experience.required' => '从业经验不能为空',
            'floorPrice.required' => '最低价格不能为空',
            'topPrice.required' => '最高价格不能为空',
            'recommend.required' => '推荐状态不能为空',
            'recommend.in' => '推荐状态不正确',
            'status.required' => '展示状态不能为空',
            'status.in' => '展示状态不正确',
            'individualResume.required' => '个人简介不能为空'
        ];
    }

}
