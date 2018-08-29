<?php

use yii\db\Migration;

/**
 * Class m180828_133220_create_table_rule_instances
 */
class m180828_133220_create_table_rule_instances extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rule_instances', [
            'id'                => $this->primaryKey(),
            'rule_id'           => $this->integer()->notNull(),
            'work_shift_id'     => $this->integer()->notNull(),
            'quota'             => $this->integer()->defaultValue(0),
            'count'             => $this->integer()->defaultValue(0),
        ]);
        $this->createIndex(
            'rule_instances_work_shift',
            'rule_instances',
            'work_shift_id'
        );
        $this->createIndex(
            'rule_instances_rule',
            'rule_instances',
            'rule_id'
        );
        $this->addForeignKey(
            'rule_instances_rel_work_shifts',
            'rule_instances',
            'work_shift_id',
            'work_shifts',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'rule_instances_rel_rules',
            'rule_instances',
            'rule_id',
            'rules',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_133220_create_table_rule_instances cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_133220_create_table_rule_instances cannot be reverted.\n";

        return false;
    }
    */
}
