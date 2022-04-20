<?php

namespace App\Applet\Service\Impl;

use App\Applet\Service\IFeedbackService;
use App\Models\Feedback;

/**
 * 反馈意见服务接口实现
 */
class FeedbackServiceImpl implements IFeedbackService
{

    /**
     * 反馈
     * @param array $feedback
     * @return int
     */
    function feedback(array $feedback): int
    {
        return Feedback::addFeedback($feedback);
    }
}
