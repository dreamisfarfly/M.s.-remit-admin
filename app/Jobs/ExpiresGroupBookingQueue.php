<?php

namespace App\Jobs;

use App\Applet\Service\Impl\GroupBookingServiceImpl;
use App\Applet\Service\Impl\OrderServiceImpl;
use App\Core\Exception\ParametersException;
use App\Models\GroupBooking;
use App\Models\GroupBookingInfo;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

/**
 * 拼团失效
 */
class ExpiresGroupBookingQueue implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 拼团编号
     * @var int
     */
    protected int $groupId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws ParametersException
     */
    public function handle(GroupBookingServiceImpl $groupBookingServiceImpl, OrderServiceImpl $orderServiceImpl)
    {
        try{
            //更改拼团状态
            $groupBookingServiceImpl->updated($this->groupId, ['status' => GroupBooking::HAVE_EXPIRED]);
            // 退款
            $list = GroupBookingInfo::listview($this->groupId);
            foreach ($list as $item) {
                $orderInfo = $orderServiceImpl->show($item->id);
                $app = Factory::payment(config('wechat.payment.default'));
                $refundOrdersNo = self::refundOrdersNo();
                $app->refund->byTransactionId(
                    $orderInfo->order_no,
                    $refundOrdersNo,
                    $orderInfo->total_price * 100,
                    $orderInfo->total_price * 100
                );
                $orderServiceImpl->updatedOrder($orderInfo->id,['refund_orders_no' => $refundOrdersNo]);
            }
        }catch (InvalidConfigException $exception){
            throw new ParametersException('退款失败');
        }
    }

    /**
     * 退款订单
     * @return string
     */
    protected function refundOrdersNo(): string
    {
        return date('YmdHis').rand(100000,999999);
    }

}
