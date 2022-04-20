<?php

namespace App\Admin\Service;

interface ISysMenuService
{

    /**
     * 根据用户ID查询菜单树信息
     *
     * @param int $userId
     * @return mixed 菜单列表
     */
    function selectMenuTreeByUserId(int $userId);

}
