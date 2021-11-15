<?php

namespace App\Core\Util;

use App\Core\Enum\ErrorState;
use Illuminate\Http\JsonResponse;

/**
 * JSON格式返回
 */
trait FastJson
{

    /**
     * 成功返回
     * @param array $data
     * @return JsonResponse
     */
    public function success($data = []): JsonResponse
    {
        return response()->json([
            'code' => ErrorState::SUCCESS,
            'message' => '成功',
            'data' => $data
        ]);
    }

    /**
     * 失败返回
     * @param string $message
     * @return JsonResponse
     */
    public function error(string $message): JsonResponse
    {
        return response()->json([
            'code' => ErrorState::PARAMETER,
            'message' => $message
        ]);
    }

}
