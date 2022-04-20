<?php

namespace App\Admin\Service;

use Illuminate\Http\Request;

/**
 * 横幅服务接口
 */
interface IBannerService
{

    /**
     * 横幅列表
     * @param Request $request
     * @return mixed
     */
    function listview(Request $request);

    /**
     * 更改横幅状态
     * @param int $id
     * @param int $status
     * @return mixed
     */
    function changeState(int $id, int $status);

    /**
     * 删除轮播图
     * @param int $id 编号
     * @return mixed
     */
    function delBanner(int $id);

    /**
     * 新增轮播图片
     * @param array $data
     * @return mixed
     */
    function append(array $data);

    /**
     * 详情
     * @param int $id
     * @return mixed
     */
    function details(int $id);

    /**
     * 更新轮播图
     * @param int $id
     * @param array $data
     * @return mixed
     */
    function update(int $id, array $data);

}
