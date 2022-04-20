<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 推荐
 */
class RecommendRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'recommend' => [
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
            'recommend.required' => '推荐状态不能为空',
            'recommend.in' => '推荐状态不正确'
        ];
    }

}
