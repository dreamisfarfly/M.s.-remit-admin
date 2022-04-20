<?php

namespace App\Admin\Service\Impl;

use App\Admin\Service\IBannerService;
use App\Models\Banners;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * 横幅接口实现
 */
class BannerServiceImpl implements IBannerService
{

    /**
     * 横幅列表
     * @param Request $request
     * @return object
     */
    public function listview(Request $request): object
    {
        //初始法搜索的值
        $data = [];
        if($request->exists('bannerType') && $request->get('bannerType') != '')
        {
            $data['type'] = $request->get('bannerType');
        }
        $dataList = Banners::adminListview($data);
        $data = collect($dataList->items());
        $data->map(function($item){
            $item->location = config('filesystems.disks.file.url').$item->location;
        });
        return (object)[
            "data" => $data,
            "meta" => [
                "total" => $dataList->total(),
                'page' => $dataList->currentPage()
            ]
        ];
    }

    /**
     * 更改横幅状态
     * @param int $id
     * @param int $status
     * @return bool
     */
    function changeState(int $id, int $status): bool
    {
        return Banners::updateBanner($id,['status'=>$status]);
    }

    /**
     * 删除轮播图
     * @param int $id 编号
     * @return mixed
     */
    function delBanner(int $id)
    {
        return Banners::delBanner($id);
    }

    /**
     * 新增轮播图片
     * @param array $data
     * @return bool
     */
    function append(array $data): bool
    {
       return Banners::appendBanner($data);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    function details(int $id)
    {
        $bannerInfo = Banners::details($id);
        if($bannerInfo != null)
            $bannerInfo->type = (string)$bannerInfo->type;
            $bannerInfo->status = (string)$bannerInfo->status;
            $bannerInfo->location = config('filesystems.disks.file.url').$bannerInfo->location;
        return $bannerInfo;
    }

    /**
     * 更新轮播图
     * @param int $id
     * @param array $data
     * @return int
     */
    function update(int $id, array $data): int
    {
        if(strpos($data['location'],config('filesystems.disks.file.url')) !== false){
            unset($data['location']);
        }
        return Banners::updatedBanner($id, $data);
    }
}
