<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\AdminCore\Exception\ParametersException;
use App\Admin\Request\UploadImgRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

/**
 * 公用接口
 */
class CommonsController extends AdminController
{

    /**
     * 上传图片
     * @param UploadImgRequest $uploadImgRequest
     * @return JsonResponse
     */
    public function uploadImg(UploadImgRequest $uploadImgRequest): JsonResponse
    {
        $image = $uploadImgRequest->get('image');
        $image = str_replace('data:image/png;base64,','',$image);
        $image = str_replace(' ', '+', $image);

        $imagePath = date('YmdHis').'.png';
        Storage::disk('file')->put($imagePath,base64_decode($image));

        return AjaxResult::successData((object)[
            'url' => '/'.$imagePath
        ]);

    }

    /**
     * 上传文件
     * @return JsonResponse
     * @throws ParametersException
     */
    public function uploadsImg(): JsonResponse
    {
       $file = $this->request->file('file');
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
