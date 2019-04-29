<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:33
 */

namespace app\admin\service;


use app\common\enum\BaseStatus;
use app\common\model\Admin;
use app\common\model\AdminRoleRelation;

class Admins
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return Admin::getOrFail($id);
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $mobile
     * @return Admin
     */
    public function create(string $username, string $password, string $mobile)
    {
        return Admin::create([
            'username' => $username,
            'password' => Admin::makePassword($password),
            'mobile_phone' => $mobile,
            'status' => BaseStatus::ENABLE
        ]);
    }

    /**
     * @param Admin $admin
     * @param array $roleIds
     */
    public function bindRoles(Admin $admin, array $roleIds)
    {
        $admin->roles()->saveAll($roleIds);
    }

    /**
     * @param string $username
     * @return array|\PDOStatement|string|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getByUsername(string $username)
    {
        return Admin::where('username', $username)->findOrEmpty();
    }

    /**
     * @param Admin $admin
     * @param string $password
     * @return bool
     */
    public function checkPassword(Admin $admin, string $password)
    {
        return $admin->checkPassword($password);
    }

    /**
     * @param Admin $admin
     * @param string $password
     */
    public function setPassword(Admin $admin, string $password)
    {
        $admin->setAttr('password', Admin::makePassword($password));
        $admin->save();
    }

    /**
     * @param array $post
     */
    public function edit(array $post)
    {
        Admin::update($post);
    }

    /**
     * @param Admin $admin
     * @param array $roleIds
     * @throws \think\Exception
     */
    public function toggleRoles(Admin $admin, array $roleIds)
    {
        $admin->roles()->attach($roleIds);
    }

    /**
     * @param array $ids
     */
    public function delete(array $ids)
    {
        $roleRelationIds = AdminRoleRelation::whereIn('admin_id', $ids)->column('id');
        AdminRoleRelation::destroy($roleRelationIds);
        Admin::destroy($ids);
    }

    /**
     * @param Admin $admin
     * @param array $roleIds
     */
    public function unbindRoles(Admin $admin, array $roleIds)
    {
        $admin->roles()->detach($roleIds);
    }
}