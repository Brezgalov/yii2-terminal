<?php

use yii\db\Migration;

/**
 * Class m180828_134047_create_table_transit_rule_crops
 */
class m180828_134047_create_table_transit_rule_crops extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transit_rule_crops', [
            'id'                        => $this->primaryKey(),
            'transit_rule_id'           => $this->integer()->notNull(),
            'crop_id'                   => $this->integer()->notNull(),
        ]);
        $this->createIndex(
            'transit_rule_id',
            'transit_rule_crops',
            'transit_rule_id'
        );
        $this->createIndex(
            'crop_id',
            'transit_rule_crops',
            'crop_id'
        );
        $this->addForeignKey(
            'transit_rule_crops_rel_transit_rules',
            'transit_rule_crops',
            'transit_rule_id',
            'transit_rules',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'transit_rule_crops_rel_crops',
            'transit_rule_crops',
            'crop_id',
            'crops',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_134047_create_table_transit_rule_crops cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_134047_create_table_transit_rule_crops cannot be reverted.\n";

        return false;
    }
    */
}
