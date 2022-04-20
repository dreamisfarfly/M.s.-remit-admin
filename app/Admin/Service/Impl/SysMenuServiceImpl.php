<?php

namespace App\Admin\Service\Impl;

use App\Admin\Models\SysMenu;
use App\Admin\Models\SysUsers;
use App\Admin\Service\ISysMenuService;

class SysMenuServiceImpl implements ISysMenuService
{

    /**
     * 根据用户ID查询菜单树信息
     *
     * @param int $userId
     * @return mixed 菜单列表
     */
    function selectMenuTreeByUserId(int $userId)
    {
        $userInfo = SysUsers::userinfo($userId);
        return SysMenu::selectMenuTreeAll();
    }

}
