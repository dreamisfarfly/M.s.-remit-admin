<?php

namespace App\Applet\Request;

use App\Applet\Validators\VerifyArray;
use App\Core\Request\BaseRequest;

/**
 * 反馈请求
 */
class FeedbackRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'type' => 'required',
            'content' => 'required',
            'picture' => [
                'required',
                new VerifyArray()
            ],
            'contactWay' => [
                'required',
                //'regex:/^[1][3,5,7,8][0-9]{9}$/'
            ],
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'type.required' => '反馈类型不能为空',
            'content.required' => '反馈内容不能为空',
            'picture.required' => '反馈图片组不能为空',
            'contactWay.required' => '反馈联系电话不能为空',
            'contactWay.regex' => '反馈联系电话格式不正确'
        ];
    }

}
