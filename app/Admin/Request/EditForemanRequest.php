<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 编辑工长
 */
class EditForemanRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'buddha' => 'required',
            'siteName' => 'required',
            'nickname' => 'required',
            'workingSeniority' => [
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
            'buddha.required' => '头像不能为空',
            'nickname.required' => '昵称不能为空',
            'siteName.required' => '昵称不能为空',
            'workingSeniority.required' => '从业经验不能为空',
        ];
    }

}
