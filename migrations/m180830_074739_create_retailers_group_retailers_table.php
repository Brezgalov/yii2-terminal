<?php

use yii\db\Migration;

/**
 * Handles the creation of table `retailers_group_retailers`.
 */
class m180830_074739_create_retailers_group_retailers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('retailers_group_retailers', [
            'id' => $this->primaryKey(),
            'retailers_group_id' => $this->integer()->notNull(),
            'retailer_id' => $this->integer()->notNull(),
        ]);
        $this->createIndex(
            'retailers_group_id',
            'retailers_group_retailers',
            'retailers_group_id'
        );
        $this->createIndex(
            'retailer_id',
            'retailers_group_retailers',
            'retailer_id'
        );
        $this->addForeignKey(
            'retailers_group_retailers_rel_retailers_groups',
            'retailers_group_retailers',
            'retailers_group_id',
            'retailers_groups',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'retailers_group_retailers_rel_retailers',
            'retailers_group_retailers',
            'retailer_id',
            'retailers',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('retailers_group_retailers');
    }
}
