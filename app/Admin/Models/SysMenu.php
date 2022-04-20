<?php

namespace App\Admin\Models;

use App\Admin\AdminCore\Model\BaseModel;

/**
 * 数据权限菜单
 */
class SysMenu extends BaseModel
{

    public $table = 'sys_menu';

    public static function selectMenuTreeAll()
    {
        return self::query()
            ->orderBy('order_num')
            ->get();
    }

}
