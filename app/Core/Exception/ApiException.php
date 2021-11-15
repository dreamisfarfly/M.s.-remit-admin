<?php

namespace App\Core\Exception;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * 自定义状态码
 */
class ApiException extends Exception
{

    /**
     * 状态码
     * @var int
     */
    protected int $coreCode;

    /**
     * 返回消息
     * @var string
     */
    protected string $coreMsg;

    /**
     * 自定义状态码
     * @var int
     */
    protected int $coreErrorCode;

    /**
     * @return int
     */
    public function getCoreErrorCode(): int
    {
        return $this->coreErrorCode;
    }

    /**
     * @return string
     */
    public function getCoreMsg(): string
    {
        return $this->coreMsg;
    }

    /**
     * 报告异常
     *
     * @return false
     */
    public function report(): bool
    {
        return false;
    }

    /**
     * 渲染异常为 HTTP 响应
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function render(Request $request)
    {
        return response([
            'code' => $this->coreErrorCode,
            'message' => $this->coreMsg,
            'request_url' => $request->url()
        ],$this->coreCode);
    }

}
