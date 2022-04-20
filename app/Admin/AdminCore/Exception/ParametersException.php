<?php

namespace App\Admin\AdminCore\Exception;

/**
 * 基础异常
 */
class ParametersException extends ApiException
{

    /**
     * @var int
     */
    protected int $coreErrorCode = 500;

    /**
     * @param string $msg
     */
    public function __construct(string $msg)
    {
        $this->coreMsg = $msg;
    }

}
