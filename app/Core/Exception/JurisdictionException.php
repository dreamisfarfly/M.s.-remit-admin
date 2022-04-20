<?php

namespace App\Core\Exception;

/**
 * 权限异常
 */
class JurisdictionException extends ApiException
{

    /**
     * @var int
     */
    protected int $coreErrorCode = 1000;

    /**
     * @param string $msg
     */
    public function __construct(string $msg)
    {
        $this->coreMsg = $msg;
    }

}
