<?php

namespace App\Jobs;

use App\Applet\Service\Impl\OrderServiceImpl;
use App\Models\Goods;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * 普通订单队列
 */
class OrdinaryOrderQueue implements ShouldQueue
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
        //销量增加
        Goods::query()
            ->where('id',$orderInfo->goodsList[0]->goods_id)
            ->increment('sales_volume',$orderInfo->goodsList[0]->count);
    }
}
