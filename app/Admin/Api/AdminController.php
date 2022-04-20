<?php

namespace App\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * 管理员控制器
 */
class AdminController extends Controller
{

    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

}
