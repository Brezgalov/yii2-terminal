<?php

use yii\db\Migration;

/**
 * Handles the creation of table `retailers_groups`.
 */
class m180830_073843_create_retailers_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('retailers_groups', [
            'id' => $this->primaryKey(),
            'rule_id' => $this->integer()->notNull(),
            'quota' => $this->integer()->notNull(),
        ]);
        $this->createIndex(
            'rule_id',
            'retailers_groups',
            'rule_id'
        );
        $this->addForeignKey(
            'retailers_groups_rel_rules',
            'retailers_groups',
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
        $this->dropTable('retailers_groups');
    }
}
