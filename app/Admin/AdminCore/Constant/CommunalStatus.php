<?php

namespace App\Admin\AdminCore\Constant;

/**
 * 公用常量
 */
class CommunalStatus
{

    /********  删除状态  *********/
    //没有删除
    const NOT_DELETE = 0;

    //删除了
    const YES_DELETE = 1;

    /******** 上下架状态 ********/
    //上架
    const ADDED = 0;

    //下架
    const SOLD_OUT = 1;

    /******** 展示状态 ********/
    //展示
    const SHOW = 0;

    //隐藏
    const HIDE = 1;

    /******* 推荐状态 ********/
    //推荐
    const YES_RECOMMEND = 0;

    //不推荐
    const NOT_RECOMMEND = 1;

}
