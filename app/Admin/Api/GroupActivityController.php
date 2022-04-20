<?php

namespace App\Admin\Api;

use App\Admin\AdminCore\Constant\CommunalStatus;
use App\Admin\AdminCore\Domain\AjaxResult;
use App\Admin\AdminCore\Exception\ParametersException;
use App\Admin\Request\EditGroupActivityRequest;
use App\Admin\Service\IGroupActivityService;
use App\Admin\Service\Impl\GroupActivityServiceImpl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 团购商品
 */
class GroupActivityController extends AdminController
{

    /**
     * @var IGroupActivityService
     */
    protected IGroupActivityService $groupActivityService;

    /**
     * @param Request $request
     * @param GroupActivityServiceImpl $groupActivityService
     */
    public function __construct(Request $request, GroupActivityServiceImpl $groupActivityService)
    {
        parent::__construct($request);
        $this->groupActivityService = $groupActivityService;
    }

    /**
     * 列表
     * @return JsonResponse
     */
    public function listview(): JsonResponse
    {
        $searchParam = [];
        $request = $this->request;
        if($request->exists('title') && $request->get('title') != '')
        {
            $searchParam['title'] = $request->get('title');
        }
        if($request->exists('status') && $request->get('status') != '')
        {
            $searchParam['status'] = $request->get('status');
        }
        return AjaxResult::successData(
          $this->groupActivityService->list($searchParam)
        );
    }

    /**
     * 添加
     * @param EditGroupActivityRequest $editGroupActivityRequest
     * @return JsonResponse
     * @throws ParametersException
     */
    public function add(EditGroupActivityRequest $editGroupActivityRequest): JsonResponse
    {
        $time = $editGroupActivityRequest->get('activityTime');
        if(count($time ) != 2){
            throw new ParametersException('活动时间格式错误');
        }
        $this->groupActivityService->add([
            'goods_id' => $editGroupActivityRequest->get('goodsId'),
            'title' => $editGroupActivityRequest->get('title'),
            'surface_plot' => $editGroupActivityRequest->get('surfacePlot'),
            'group_price' => $editGroupActivityRequest->get('groupPrice'),
            'start_end' => $time[0],
            'end_time' => $time[1],
            'restriction_count' => $editGroupActivityRequest->get('restrictionCount'),
            'clustering_count' => $editGroupActivityRequest->get('clusteringCount'),
            'status' => $editGroupActivityRequest->get('status')
        ]);
        return AjaxResult::success();
    }

    /**
     * 更新
     * @param int $id
     * @param EditGroupActivityRequest $editGroupActivityRequest
     * @return JsonResponse
     * @throws ParametersException
     */
    public function update(int $id, EditGroupActivityRequest $editGroupActivityRequest): JsonResponse
    {
        $time = $editGroupActivityRequest->get('activityTime');
        if(count($time ) != 2){
            throw new ParametersException('活动时间格式错误');
        }
        $this->groupActivityService->update($id,[
            'goods_id' => $editGroupActivityRequest->get('goodsId'),
            'title' => $editGroupActivityRequest->get('title'),
            'surface_plot' => $editGroupActivityRequest->get('surfacePlot'),
            'group_price' => $editGroupActivityRequest->get('groupPrice'),
            'start_end' => $time[0],
            'end_time' => $time[1],
            'restriction_count' => $editGroupActivityRequest->get('restrictionCount'),
            'clustering_count' => $editGroupActivityRequest->get('clusteringCount'),
            'status' => $editGroupActivityRequest->get('status')
        ]);
        return AjaxResult::success();
    }

    /**
     * 删除
     * @param int $id
     * @return JsonResponse
     */
    public function del(int $id): JsonResponse
    {
        $this->groupActivityService->update($id,['is_del' => CommunalStatus::YES_DELETE]);
        return AjaxResult::success();
    }

    /**
     * 详情
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return AjaxResult::successData(
            $this->groupActivityService->show($id)
        );
    }

}
