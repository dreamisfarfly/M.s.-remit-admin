<?php

namespace App\Admin\AdminCore\Exception;

/**
 * 无权限
 */
class JurisdictionException extends ApiException
{

    /**
     * @var int
     */
    protected int $coreErrorCode = 401;

    /**
     * @param string $msg
     */
    public function __construct(string $msg)
    {
        $this->coreMsg = $msg;
    }

}
