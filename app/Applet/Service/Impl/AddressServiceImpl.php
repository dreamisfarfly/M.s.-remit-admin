<?php

namespace App\Applet\Service\Impl;

use App\Applet\Service\IAddressService;
use App\Models\Address;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * 地址服务接口实现
 */
class AddressServiceImpl implements IAddressService
{

    /**
     * 列表
     * @param int $userId
     * @return Builder[]|Collection
     */
    function listview(int $userId)
    {
        return Address::listview($userId);
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    function add(array $data): bool
    {
        return Address::add($data);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return int
     */
    function update(int $id, array $data): int
    {
        if($data['status'] == 0){
            $this->updateUserDefault($data['user_id']);
        }
        return Address::updateAddress($id,$data);
    }

    /**
     * 详情
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    function show(int $id)
    {
        return Address::show($id);
    }

    /**
     * 更新
     * @param int $userId
     * @return int
     */
    protected function updateUserDefault(int $userId): int
    {
        return Address::updateByUserId($userId,['status'=>1]);
    }

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    function del(int $id)
    {
        return Address::del($id);
    }
}
