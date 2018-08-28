<?php

use yii\db\Migration;

/**
 * Class m180828_133220_create_table_transit_rule_instances
 */
class m180828_133220_create_table_transit_rule_instances extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transit_rule_instances', [
            'id'                => $this->primaryKey(),
            'transit_rule_id'   => $this->integer()->notNull(),
            'work_shift_id'     => $this->integer()->notNull(),
            'quota'             => $this->integer()->defaultValue(0),
            'registered'        => $this->integer()->defaultValue(0),
        ]);
        $this->createIndex(
            'transit_rule_instances_work_shift',
            'transit_rule_instances',
            'work_shift_id'
        );
        $this->createIndex(
            'transit_rule_instances_transit_rule',
            'transit_rule_instances',
            'transit_rule_id'
        );
        $this->addForeignKey(
            'transit_rule_instances_rel_work_shifts',
            'transit_rule_instances',
            'work_shift_id',
            'work_shifts',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'transit_rule_instances_rel_transit_rules',
            'transit_rule_instances',
            'transit_rule_id',
            'transit_rules',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_133220_create_table_transit_rule_instances cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_133220_create_table_transit_rule_instances cannot be reverted.\n";

        return false;
    }
    */
}
