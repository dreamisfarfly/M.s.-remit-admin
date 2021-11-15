<?php

namespace App\Core\Exception;

use App\Core\Enum\ErrorState;

/**
 * 基础异常
 */
class ParametersException extends ApiException
{

    /**
     * @var int
     */
    protected int $coreCode = 200;

    /**
     * @var int
     */
    protected int $coreErrorCode = ErrorState::PARAMETER;

    /**
     * @param string $msg
     */
    public function __construct(string $msg)
    {
        $this->coreMsg = $msg;
    }

}
