<?php

namespace App\Core\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * 接口基类控制器
 */
class ApiController extends Controller
{

    /**
     * @var Request
     */
    public Request $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

}
