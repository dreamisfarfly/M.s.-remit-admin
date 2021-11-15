<?php

use App\Core\Controller\ApiController;
use Illuminate\Http\Request;

/**
 * 地址控制器
 */
class AddressController extends ApiController
{

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    

}