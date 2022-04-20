<?php

namespace App\Applet\Service;

/**
 * 帮助反馈服务接口
 */
interface IProblemFeedbackService
{

    /***
     * 帮助反馈列表
     *
     * @return mixed
     */
    function listview();

    /***
     * 用户操作反馈列表
     *
     * @param int|null $userId
     * @return mixed
     */
    function handleListview(?int $userId);

}
