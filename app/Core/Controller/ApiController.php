<?php

namespace App\Core\Controller;

use App\Core\Util\FastJson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * 接口基类
 */
class ApiController extends Controller
{

    use FastJson;

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
