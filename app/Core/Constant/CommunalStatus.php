<?php

namespace App\Core\Constant;

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

    /********* 默认状态  *********/
    //默认
    const YES_DEFAULT = 0;

    //不默认
    const NOT_DEFAULT = 1;

}
