<?php

namespace App\Admin\AdminCore\Domain;


use App\Admin\AdminCore\Constant\HttpStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

/**
 * 操作消息提醒
 */
class AjaxResult
{

    /** 状态码 */
    const CODE_TAG = "code";

    /** 返回内容 */
    const MSG_TAG = "msg";

    /** 数据对象 */
    const DATA_TAG = "data";

    /***
     * 初始化一个json返回数组
     * @param int $code
     * @param string $msg
     * @param object|null $data
     * @return JsonResponse
     */
    public static function standard(int $code, string $msg, ?object $data): JsonResponse
    {
        $_data = [
            self::CODE_TAG => $code,
            self::MSG_TAG => $msg
        ];
        if($data != null){
            if($data instanceof LengthAwarePaginator){
                $temp['data'] = $data->items();
                $temp['meta'] = [
                    'total' => $data->total(),
                    'page' => $data->currentPage()
                ];
            }else{
                $temp = $data;
            }
            $_data[self::DATA_TAG] = $temp;
        }
        else
            $_data[self::DATA_TAG] = new \StdClass();
        return response()->json($_data);
    }

    /***
     * 返回成功消息
     * @return JsonResponse
     */
    public static function success(): JsonResponse
    {
        return AjaxResult::successMsg('操作成功');
    }

    /**
     * 返回成功数据
     * @param object|null $data
     * @return JsonResponse
     */
    public static function successData(?object $data): JsonResponse
    {
        return AjaxResult::successMsgAndData('操作成功', $data);
    }

    /***
     * 返回成功消息
     * @param string $msg
     * @return JsonResponse
     */
    public static function successMsg(string $msg): JsonResponse
    {
        return AjaxResult::successMsgAndData($msg, null);
    }

    /***
     * 返回成功消息
     *
     * @param string $msg
     * @param object|null $data
     * @return JsonResponse
     */
    public static function successMsgAndData(string $msg, ?object $data): JsonResponse
    {
        return AjaxResult::standard(HttpStatus::SUCCESS, $msg, $data);
    }

}
