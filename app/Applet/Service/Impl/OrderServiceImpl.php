<?php

namespace App\Applet\Service\Impl;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Applet\Service\IOrderService;
use App\Core\Exception\ParametersException;
use App\Jobs\OrderAutomaticallyExpireQueue;
use App\Jobs\OrdinaryOrderQueue;
use App\Jobs\SpellGroupOrderQueue;
use App\Models\Address;
use App\Models\Goods;
use App\Models\GroupActivity;
use App\Models\Order;
use App\Models\OrderInfo;
use Carbon\Carbon;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Exceptions\Exception;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\Kernel\Support\XML;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * 订单服务接口实现
 */
class OrderServiceImpl implements IOrderService
{

    /**
     * 列表
     * @param array $params
     * @return object
     */
    function listview(array $params): object
    {
        $orderList = Order::orderListview($params);
        $data = collect($orderList->items());
        $data->map(function($item){
            if(count($item->common) != 0)
            {
                $goodsList = collect($item->common);
                $goodsList->map(function($items){
                   $items->title =  $items->goods->title;
                   $items->surface_plot =  config('filesystems.disks.file.url').$items->goods->surface_plot;
                   $items->price =  $items->goods->price;
                   unset($items->goods);
                });
                $item->goodsList = $item->common;
            }
            if(count($item->group) != 0)
            {
                $goodsList = collect($item->group);
                $goodsList->map(function($items){
                    $items->title =  $items->groupActivity->title;
                    $items->surface_plot =  config('filesystems.disks.file.url').$items->groupActivity->surface_plot;
                    $items->price =  $items->groupActivity->group_price;
                    unset($items->groupActivity);
                });
                $item->goodsList = $item->group;
            }
            if($item->status == Order::NOT_PAID)
            {
                //未支付显示过期时间
                $item->expirationTime = strtotime($item->created_at." +".Order::EXPIRATION_TIME." minute") - time();;
            }
            unset($item->common);
            unset($item->group);
        });
        return (object)[
            'data' => $data,
            'meta' => [
                'total' => $orderList->total(),
                'page' => $orderList->currentPage(),
                'lastPage' => $orderList->lastPage()
            ]
        ];
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    function show(int $id)
    {
        $dataInfo = Order::show($id);
        if($dataInfo == null)
            return null;
        $totalGoods = 0;
        if(count($dataInfo->common) > 0)
        {
            $goodsList = collect($dataInfo->common);
            $goodsList->each(function($item) use (&$totalGoods) {
               if($item->goods != null){
                   $item->title = $item->goods->title;
                   $item->surface_plot = config('filesystems.disks.file.url').$item->goods->surface_plot;
                   $item->price = $item->goods->price;
                   $totalGoods += ($item->goods->price*$item->count);
                   unset($item->goods);
               }
            });
            $dataInfo->goodsList = $goodsList;
        }
        if(count($dataInfo->group) > 0)
        {
            $goodsList = collect($dataInfo->group);
            $goodsList->each(function($item) use (&$totalGoods) {
               if($item->groupActivity != null){
                   $item->title = $item->groupActivity->title;
                   $item->surface_plot = config('filesystems.disks.file.url').$item->groupActivity->surface_plot;
                   $item->price = $item->groupActivity->group_price;
                   $item->clusteringCount = $item->groupActivity->clustering_count;
                   $totalGoods += ($item->groupActivity->group_price*$item->count);
                   unset($item->groupActivity);
               }
            });
            $dataInfo->goodsList = $goodsList;
        }
        $dataInfo->totalGoods = $totalGoods;
        if($dataInfo->status == Order::NOT_PAID)
        {
            //未支付显示过期时间
            $dataInfo->expirationTime = strtotime($dataInfo->created_at." +".Order::EXPIRATION_TIME." minute") - time();;
        }
        unset($dataInfo->common);
        unset($dataInfo->group);
        return $dataInfo;
    }

    /**
     * 订单详情
     * @param string $orderNo
     * @return mixed
     */
    function showByOrderNo(string $orderNo)
    {
        $dataInfo = Order::showByOrderNo($orderNo);
        if($dataInfo == null)
            return null;
        $totalGoods = 0;
        if(count($dataInfo->common) > 0)
        {
            $goodsList = collect($dataInfo->common);
            $goodsList->each(function($item) use (&$totalGoods) {
                if($item->goods != null){
                    $item->title = $item->goods->title;
                    $item->surface_plot = config('filesystems.disks.file.url').$item->goods->surface_plot;
                    $item->price = $item->goods->price;
                    $totalGoods += ($item->goods->price*$item->count);
                    unset($item->goods);
                }
            });
            $dataInfo->goodsList = $goodsList;
        }
        if(count($dataInfo->group) > 0)
        {
            $goodsList = collect($dataInfo->group);
            $goodsList->each(function($item) use (&$totalGoods) {
                if($item->groupActivity != null){
                    $item->title = $item->groupActivity->title;
                    $item->surface_plot = config('filesystems.disks.file.url').$item->groupActivity->surface_plot;
                    $item->price = $item->groupActivity->group_price;
                    $item->clusteringCount = $item->groupActivity->clustering_count;
                    $totalGoods += ($item->groupActivity->group_price*$item->count);
                    unset($item->groupActivity);
                }
            });
            $dataInfo->goodsList = $goodsList;
        }
        $dataInfo->totalGoods = $totalGoods;
        unset($dataInfo->common);
        unset($dataInfo->group);
        return $dataInfo;
    }

    /**
     * 订单信息
     * @param array $data
     * @return object
     */
    function orderInformation(array $data): object
    {
        $addressInfo = Address::defaultSite($data['user_id']);
        if($data['type'] == 'common')
        {
            $goods = Goods::show($data['id']);
            $goodsInfo = [
                'title' => $goods->title,
                'surface_plot' => config('filesystems.disks.file.url').$goods->surface_plot,
                'price' => $goods->price,
                'count' => $data['count'],
                'type' => 'common',
            ];
        }else{
            $goods = GroupActivity::show($data['id']);
            $goodsInfo = [
                'title' => $goods->title,
                'surface_plot' => config('filesystems.disks.file.url').$goods->surface_plot,
                'price' => $goods->group_price,
                'count' => $data['count'],
                'type' => 'group',
            ];
        }
        return (object)[
            'addressInfo' => $addressInfo,
            'goodsInfo' => $goodsInfo,
            'stat' => [
                'totalGoods' => $goodsInfo['price'] * $goodsInfo['count'],
                'total_price' =>  $goodsInfo['price'] * $goodsInfo['count'],
            ]
        ];
    }

    /**
     * 创建订单
     * @param array $data
     * @return object
     * @throws ParametersException
     */
    function createdOrder(array $data): object
    {
        switch ($data['type'])
        {
            case 0:
                return self::commonOrder($data);
            case 1:
                return self::bulkOrder($data);
        }
        throw new ParametersException('订单类型错误');
    }

    /**
     * 普通订单
     * @param array $data
     * @return object
     * @throws ParametersException
     */
    private function commonOrder(array $data): object
    {
        $addressInfo = Address::show($data['addressId']);
        $goodsInfo = Goods::show($data['id']);
        if($goodsInfo->inventory <= 0){
            throw new ParametersException('库存不足');
        }
        try{
            DB::beginTransaction();
            $orderId = Order::addGetId([
                'user_id' => $data['userId'],
                'type' => $data['type'],
                'order_no' => self::getOrderNo(),
                'status' => Order::NOT_PAID,
                'consignee' => $addressInfo->name,
                'phone' => $addressInfo->phone,
                'province' => $addressInfo->province,
                'city' => $addressInfo->city,
                'area' => $addressInfo->area,
                'detailed_address' => $addressInfo->detailed_address,
                'leave_word' => $data['leaveWord'],
                'total_price' => $goodsInfo->price * $data['count'],
                'delivery_time' => $data['deliveryTime'],
            ]);
            Goods::decrementGoodsInventory($data['id'],$data['count']);
            OrderInfo::add([
                'order_id' => $orderId,
                'goods_id' => $data['id'],
                'count' => $data['count'],
                'type' => $data['type']
            ]);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw new ParametersException('创建订单失败');
        }
        OrderAutomaticallyExpireQueue::dispatch($orderId)->delay(Carbon::now()->addMinutes(Order::EXPIRATION_TIME));
        return (object)[
            'orderId' => $orderId
        ];
    }

    /**
     * 团购订单
     * @param array $data
     * @return object
     * @throws ParametersException
     */
    private function bulkOrder(array $data): object
    {
        $addressInfo = Address::show($data['addressId']);
        $goodsInfo = GroupActivity::show($data['id']);
        try{
            DB::beginTransaction();
            $orderId = Order::addGetId([
                'user_id' => $data['userId'],
                'type' => $data['type'],
                'order_no' => self::getOrderNo(),
                'status' => Order::NOT_PAID,
                'consignee' => $addressInfo->name,
                'phone' => $addressInfo->phone,
                'province' => $addressInfo->province,
                'city' => $addressInfo->city,
                'area' => $addressInfo->area,
                'detailed_address' => $addressInfo->detailed_address,
                'leave_word' => $data['leaveWord'],
                'total_price' => $goodsInfo->group_price * $data['count'],
                'delivery_time' => $data['deliveryTime'],
            ]);
            if(isset($data['groupId'])){
                Order::updatedOrder($orderId,['group_id'=>$data['groupId']]);
            }
            OrderInfo::add([
                'order_id' => $orderId,
                'goods_id' => $data['id'],
                'count' => $data['count'],
                'type' => $data['type']
            ]);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            throw new ParametersException('创建订单失败');
        }
        //过期队列
        OrderAutomaticallyExpireQueue::dispatch($orderId)->delay(Carbon::now()->addMinutes(Order::EXPIRATION_TIME));
        return (object)[
            'orderId' => $orderId
        ];
    }

    /**
     * 创建订单号
     * @return string
     */
    private function getOrderNo(): string
    {
        return date('YmdHis').rand(100000,999999);
    }

    /**
     * 支付
     * @param int $id
     * @param int $userId
     * @return object
     * @throws ParametersException
     */
    function pay(int $id, int $userId): object
    {
        $orderInfo = self::show($id);
        if(count($orderInfo->goodsList) == 0)
        {
            throw new ParametersException('商品不存在');
        }
        try{
            $payment = Factory::payment(config('wechat.payment.default'));
            $result = $payment->order->unify([
                'body' => $orderInfo->goodsList[0]->title,
                'out_trade_no' => $orderInfo->order_no,
                'total_fee' => $orderInfo->total_price*100,
                'trade_type' => 'JSAPI',
                'openid' => $orderInfo->user->open_id
            ]);
            $jsSDK = $payment->jssdk;
            return json_decode($jsSDK->bridgeConfig($result['prepay_id']));
        }catch (InvalidArgumentException | InvalidConfigException | GuzzleException $e){
            throw new ParametersException('支付错误');
        }
    }

    /**
     * 支付回调
     * @param Request $request
     * @return Response
     * @throws ParametersException
     * @throws Exception
     */
    function callback(Request $request): Response
    {
        $notify = $this->getNotify($request);
        $config = config('wechat.payment.default');
        $config['app_id'] = $notify->appid;
        $payment = Factory::payment(config('wechat.payment.default'));
        return $payment->handlePaidNotify(function($message, $fail){

            //根据返回的订单号查询订单数据
            $orderInfo = self::showByOrderNo($message['out_trade_no']);

            if(!$orderInfo) {
                $fail('订单不存在');
            }

            if($orderInfo->status == Order::HAVE_PAID){
                return true;
            }

            // 支付成功后的业务逻辑
            if($message['result_code'] === 'SUCCESS')
            {
                switch ($orderInfo->type){
                    case Order::REGULAR_ORDERS:
                        OrdinaryOrderQueue::dispatch($message['out_trade_no']);
                        break;
                    case Order::SPELL_GROUP_ORDER:
                        SpellGroupOrderQueue::dispatch($message['out_trade_no']);
                        break;
                }
            }
            return true;
        });
    }

    /**
     * 解析参数
     * @param Request $request
     * @return Collection
     * @throws ParametersException
     */
    private function getNotify(Request $request): Collection
    {
        try {
            $xml = XML::parse(strval($request->getContent()));
        }catch (\Throwable $e){
            throw new ParametersException('回调参数错误');
        }
        if(!is_array($xml) || empty($xml)) {
            throw new ParametersException('回调参数解析错误');
        }
        return new Collection($xml);
    }

    /**
     * 更新订单
     * @param int $id
     * @param array $data
     * @return int
     */
    function updatedOrder(int $id, array $data): int
    {
        return Order::updatedOrder($id,$data);
    }

    /**
     * 取消支付
     * @param int $id
     * @param int $userId
     * @return int
     * @throws ParametersException
     */
    function cancelPayment(int $id, int $userId): int
    {
        $orderInfo = self::show($id);
        if($orderInfo->user_id != $userId){
            throw new ParametersException('您没有权限这么做');
        }
        if($orderInfo->type == Order::REGULAR_ORDERS)
        {
            //普通订单
            $goodsInfo = collect($orderInfo->goodsList);
            $goodsInfo->map(function($item){
                Goods::incrementGoodsIncrement($item->goods_id,$item->count);
            });
        }
        return self::updatedOrder($id,['status' => Order::EXPIRED]);
    }

    /**
     * 删除订单
     * @param int $id
     * @param int $userId
     * @return int
     * @throws ParametersException
     */
    function delOrder(int $id,int $userId): int
    {
        $orderInfo = self::show($id);
        if($orderInfo->user_id != $userId){
            throw new ParametersException('您没有权限这么做');
        }
        return self::updatedOrder($id,['is_del' => CommunalStatus::YES_DELETE]);
    }

    /**
     * 确认收货
     * @param int $id
     * @param int $userId
     * @return int
     * @throws ParametersException
     */
    function confirmReceipt(int $id, int $userId): int
    {
        $orderInfo = self::show($id);
        if($orderInfo->user_id != $userId){
            throw new ParametersException('您没有权限这么做');
        }
        if($orderInfo->status != Order::SHIPPED){
            throw new ParametersException('订单状态不正确');
        }
        return self::updatedOrder($id, ['status' => Order::CONFIRM_RECEIPT]);
    }

    /**
     * 确认完成
     * @param int $id
     * @param int $userId
     * @return int
     * @throws ParametersException
     */
    function confirmCompleted(int $id, int $userId): int
    {
        $orderInfo = self::show($id);
        if($orderInfo->user_id != $userId){
            throw new ParametersException('您没有权限这么做');
        }
        if($orderInfo->status != Order::CONFIRM_RECEIPT){
            throw new ParametersException('订单状态不正确');
        }
        return self::updatedOrder($id, ['status' => Order::ACCOMPLISH]);
    }
}
