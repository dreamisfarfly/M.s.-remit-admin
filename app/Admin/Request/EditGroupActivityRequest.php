<?php

namespace App\Admin\Request;

use App\Admin\AdminCore\Request\BaseRequest;

/**
 * 编辑团购商品
 */
class EditGroupActivityRequest extends BaseRequest
{

    /**
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'surfacePlot' => 'required',
            'status' => [
                'required',
                'in:0,1'
            ],
            'groupPrice' => [
                'required'
            ],
            'restrictionCount' => [
                'required'
            ],
            'clusteringCount' => [
                'required'
            ],
            'activityTime' => [
                'required'
            ],
            'goodsId' => [
                'required'
            ]
        ];
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'title.required' => '标题不能为空',
            'surfacePlot.required' => '封面图不能为空',
            'status.required' => '状态不能为空',
            'status.in' => '状态范围不正确',
            'groupPrice.required' => '团购价格不能为空',
            'restrictionCount.required' => '限购数量不能为空',
            'clusteringCount.required' => '成团数量不能为空',
            'activityTime.required' => '活动时间不能为空',
            'goodsId.required' => '商品编号不能为空'
        ];
    }

}
