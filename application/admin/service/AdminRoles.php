<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/4/14
 * Time: 20:46
 */

namespace app\admin\service;


use app\common\enum\BaseStatus;
use app\common\model\AdminRole;
use app\common\model\AdminRoleRelation;

class AdminRoles
{
    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return AdminRole::getOrFail($id);
    }

    /**
     * @param string $name
     * @return AdminRole
     */
    public function create(string $name)
    {
        return AdminRole::create([
            'name' => $name,
            'status' => BaseStatus::ENABLE
        ]);
    }

    /**
     * @param AdminRole $adminRole
     * @param array $ruleIds
     */
    public function allocationRules(AdminRole $adminRole, array $ruleIds)
    {
        $adminRole->rules()->saveAll($ruleIds);
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return AdminRole::all();
    }

    /**
     * @param $post
     */
    public function edit($post)
    {
        AdminRole::update($post);
    }

    /**
     * @param AdminRole $adminRole
     * @param array $ruleIds
     * @throws \think\Exception
     */
    public function toggleRules(AdminRole $adminRole, array $ruleIds)
    {
        $adminRole->rules()->attach($ruleIds);
    }

    /**
     * @param array $ids
     */
    public function delete(array $ids)
    {
        $roleRelationIds = AdminRoleRelation::whereIn('role_id', $ids)->column('id');
        AdminRoleRelation::destroy($roleRelationIds);
        AdminRole::destroy($ids);
    }

    /**
     * @param AdminRole $adminRole
     * @param array $ruleIds
     */
    public function revokeRules(AdminRole $adminRole, array $ruleIds)
    {
        $adminRole->rules()->detach($ruleIds);
    }
}