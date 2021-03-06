<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateAdminRoleRuleRelationTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $this->table('admin_role_rule_relation')
            ->setId(false)->setPrimaryKey('id')->setEngine('InnoDB')
            ->addColumn('id', 'biginteger', ['identity'=>true, 'signed'=>false])
            ->addColumn('role_id', 'biginteger', ['signed'=>false])
            ->addColumn('rule_id', 'biginteger', ['signed'=>false])
            ->addColumn('create_time', 'integer', ['limit'=>10, 'signed'=>false])
            ->addColumn('update_time', 'integer', ['limit'=>10, 'signed'=>false])
            ->addIndex(['role_id', 'rule_id'])
            ->create();
    }

    public function down()
    {
        $this->dropTable('admin_role_rule_relation');
    }
}
