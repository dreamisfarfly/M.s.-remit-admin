<?php

namespace App\Jobs;

use App\Applet\Service\Impl\OrderServiceImpl;
use App\Models\Goods;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * 订单自动过期
 */
class OrderAutomaticallyExpireQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 订单编号
     * @var int
     */
    protected int $orderId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(OrderServiceImpl $orderServiceImpl)
    {
        $orderInfo = $orderServiceImpl->show($this->orderId);
        if($orderInfo->status == Order::NOT_PAID){
            //没有支付就过期
            $orderServiceImpl->updatedOrder($orderInfo->id,['status'=>Order::EXPIRED]);
            if($orderInfo->type == Order::REGULAR_ORDERS)
            {
                //普通订单
                $goodsInfo = collect($orderInfo->goodsList);
                $goodsInfo->map(function($item){
                    Goods::incrementGoodsIncrement($item->goods_id,$item->count);
                });
            }
        }
    }
}
