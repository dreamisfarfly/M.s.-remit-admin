<?php

namespace App\Applet\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\AdminCore\Exception\ParametersException;
use App\Admin\Request\UploadImgRequest;
use App\Core\Api\ApiController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

/**
 * 公用接口
 */
class CommonsController extends ApiController
{

    /**
     * 上传文件
     * @return JsonResponse
     * @throws ParametersException
     */
    public function uploadsImg(): JsonResponse
    {
       $file = $this->request->file('files');
       if (!$file->isValid()) {
           throw new ParametersException('图片必须存在');
       }
       $realPath = $file->getRealPath();
       $imagePath = date('YmdHis').'.png';
       Storage::disk('file')->put($imagePath,file_get_contents($realPath));
       return AjaxResult::successData((object)[
           'url' => '/'.$imagePath
       ]);
    }

}
