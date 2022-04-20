<?php

namespace App\Admin\AdminCore\Config;

/**
 * 后台配置文件
 */
interface Configuration
{

    /**
     * 签名
     */
    const SING = 'abcdefghijklmnopqrstuvwxyz';

    /**
     * 过期时间
     */
    const EXPIRE = 7200;

    /**
     * 签发者
     */
    const ISSUER = 'ruoyvkjadmin';

}
