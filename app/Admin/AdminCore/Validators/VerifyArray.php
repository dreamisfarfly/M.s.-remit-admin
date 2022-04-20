<?php

namespace App\Admin\AdminCore\Validators;

use Illuminate\Contracts\Validation\Rule;

/**
 * 验证数组
 */
class VerifyArray implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if(is_array($value))
            return true;
        $arr = json_decode($value);
        if(!is_array($arr))
            return false;
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return '类型不正确,应为数组类型';
    }

}
