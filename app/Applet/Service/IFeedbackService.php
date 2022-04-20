<?php

namespace App\Applet\Service;

/**
 * 反馈意见服务接口
 */
interface IFeedbackService
{

    /**
     * 反馈
     * @param array $feedback
     * @return mixed
     */
    function feedback(array $feedback);

}
