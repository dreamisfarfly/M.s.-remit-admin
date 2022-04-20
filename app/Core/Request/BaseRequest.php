<?php

namespace App\Core\Request;

use App\Core\Exception\ParametersException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * 请求自定义基类
 */
class BaseRequest extends FormRequest
{

    /**
     * @param Validator $validator
     * @throws ParametersException
     */
    public function failedValidation(Validator $validator)
    {
        $error = $validator->errors()->first();
        throw new ParametersException($error);
    }

}
