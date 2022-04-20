<?php

namespace App\Applet\Service\Impl;

use App\Applet\Service\IGroupBookingService;
use App\Models\GroupBooking;
use App\Models\GroupBookingInfo;
use Illuminate\Support\Collection;

/**
 * 拼团服务接口实现
 */
class GroupBookingServiceImpl implements IGroupBookingService
{

    /**
     * 商品编号
     * @param int $goodsId
     * @return Collection
     */
    function listview(int $goodsId): Collection
    {
        $dataInfo = GroupBooking::listview($goodsId);
        $dataList = collect($dataInfo);
        return $dataList->each(function($item){
            $item->nickname = $item->groupBookingInfoCaptain->order->user->nickname;
            $item->avatar_url = $item->groupBookingInfoCaptain->order->user->avatar_url;
            $item->expiration_time = strtotime($item->created_at." +".GroupBooking::EXPIRES." minute") - time();
            unset($item->groupBookingInfoCaptain);
        });
    }

    /**
     * 拼团详情
     * @param int $id
     * @return Collection
     */
    function show(int $id): Collection
    {
        $dataInfo = GroupBookingInfo::listview($id);
        $dataInfo = collect($dataInfo);
        return $dataInfo->each(function($item){
            $item->nickname = $item->order->user->nickname;
            $item->avatar_url = $item->order->user->avatar_url;
            $item->number_clusters = $item->groupBooking->number_clusters;
            $item->expiration_time = strtotime($item->groupBooking->created_at." +".GroupBooking::EXPIRES." minute") - time();
            unset($item->order);
            unset($item->groupBooking);
        });
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    function updated(int $id, array $data): int
    {
        return GroupBookingInfo::updateGroupBooking($id, $data);
    }
}
