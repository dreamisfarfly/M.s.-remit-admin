<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 反馈问题请求
 */
class ProblemFeedbackStatusRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
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
            'status.required' => '状态不能为空',
            'status.in' => '状态范围不正确'
        ];
    }

}
