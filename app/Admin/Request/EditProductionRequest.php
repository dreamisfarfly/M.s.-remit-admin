<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 编辑作品
 */
class EditProductionRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'browseNumber' => 'required',
            'genre' => 'required',
            'surfacePlot' => 'required',
            'classifyId' => 'required',
            'designerId' => 'required',
            'details' => 'required'
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'title.required' => '标题不能为空',
            'browseNumber.required' => '浏览数不能为空',
            'genre.required' => '风格不能为空',
            'surfacePlot.required' => '封面图不能为空',
            'classifyId.required' => '类型不能为空',
            'designerId.required' => '设计师不能为空',
            'details.required' => '详情不能为空',
        ];
    }

}
