<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 编辑反馈问题
 */
class EditProblemFeedbackRequest extends BaseRequest
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
            'title' => 'required',
            'weight' => [
                'required'
            ],
            'problem' => 'required'
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'status.required' => '状态不能为空',
            'status.in' => '状态范围不正确',
            'title.required' => '标题不能为空',
            'problem.required' => '答案不能为空',
            'weight.required' => '权重不能为空',
        ];
    }

}
