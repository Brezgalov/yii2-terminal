<?php

use yii\db\Migration;

/**
 * Class m180828_134059_create_table_transit_rule_retailers
 */
class m180828_134059_create_table_transit_rule_retailers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transit_rule_retailers', [
            'id'                        => $this->primaryKey(),
            'transit_rule_id'           => $this->integer()->notNull(),
            'retailer_id'               => $this->integer()->notNull(),
        ]);
        $this->createIndex(
            'transit_rule_id',
            'transit_rule_retailers',
            'transit_rule_id'
        );
        $this->createIndex(
            'retailer_id',
            'transit_rule_retailers',
            'retailer_id'
        );
        $this->addForeignKey(
            'transit_rule_retailers_rel_transit_rules',
            'transit_rule_retailers',
            'transit_rule_id',
            'transit_rules',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'transit_rule_retailers_rel_retailers',
            'transit_rule_retailers',
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
        echo "m180828_134059_create_table_transit_rule_retailers cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_134059_create_table_transit_rule_retailers cannot be reverted.\n";

        return false;
    }
    */
}
