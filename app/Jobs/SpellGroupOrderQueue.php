<?php

namespace App\Jobs;

use App\Applet\Service\Impl\OrderServiceImpl;
use App\Models\GroupBooking;
use App\Models\GroupBookingInfo;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * 拼团订单队列
 */
class SpellGroupOrderQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $orderNo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $orderNo)
    {
        $this->orderNo = $orderNo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(OrderServiceImpl $orderServiceImpl)
    {
        $orderInfo = $orderServiceImpl->showByOrderNo($this->orderNo);
        //更新订单状态
        Order::updatedOrder($orderInfo->id,['status'=>Order::HAVE_PAID]);
        //拼团信息
        if($orderInfo->group_id == null)
        {
            //不是加入拼团
            $id = GroupBooking::addGetId([
                'goods_id' => $orderInfo['goodsList'][0]->goods_id,
                'number_clusters' => $orderInfo['goodsList'][0]->clusteringCount,
                'status' => GroupBooking::UNDERWAY
            ]);
            //创建拼团详情
            GroupBookingInfo::addGetId([
                'group_activity_id' => $id,
                'order_id' => $orderInfo->id,
                'type' => GroupBookingInfo::CAPTAIN
            ]);
            //自动过期拼团
            ExpiresGroupBookingQueue::dispatch($id)
                ->delay(
                    Carbon::now()
                        ->addMinutes(GroupBooking::EXPIRES)
                );
        }else{
            //加入拼团
            GroupBookingInfo::addGetId([
                'group_activity_id' => $orderInfo->group_id, //拼团编号
                'order_id' => $orderInfo->id, //订单编号
                'type' => GroupBookingInfo::PLAYER //队员
            ]);
            //查询是否拼团已经满了（满了就拼团成功）
            $groupActivityInfo = GroupBooking::show($orderInfo->group_id);
            if(GroupBookingInfo::registrationNumber($orderInfo->group_id) == $groupActivityInfo->number_clusters)
            {
                GroupBooking::updatedGroupBooking($orderInfo->group_id,['status'=>GroupBooking::FINISHED]);
            }
        }
    }
}
