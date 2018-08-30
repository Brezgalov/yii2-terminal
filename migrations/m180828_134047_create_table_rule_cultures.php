<?php

use yii\db\Migration;

/**
 * Class m180828_134047_create_table_rule_cultures
 */
class m180828_134047_create_table_rule_cultures extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rule_cultures', [
            'id'                => $this->primaryKey(),
            'rule_id'           => $this->integer()->notNull(),
            'culture_id'        => $this->integer()->notNull(),
        ]);
        $this->createIndex(
            'rule_id',
            'rule_cultures',
            'rule_id'
        );
        $this->createIndex(
            'culture_id',
            'rule_cultures',
            'culture_id'
        );
        $this->addForeignKey(
            'rule_cultures_rel_rules',
            'rule_cultures',
            'rule_id',
            'rules',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'rule_cultures_rel_cultures',
            'rule_cultures',
            'culture_id',
            'cultures',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_134047_create_table_rule_cultures cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_134047_create_table_rule_cultures cannot be reverted.\n";

        return false;
    }
    */
}
