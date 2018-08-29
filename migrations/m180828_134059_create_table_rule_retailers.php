<?php

use yii\db\Migration;

/**
 * Class m180828_134059_create_table_rule_retailers
 */
class m180828_134059_create_table_rule_retailers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rule_retailers', [
            'id'                        => $this->primaryKey(),
            'rule_id'           => $this->integer()->notNull(),
            'retailer_id'               => $this->integer()->notNull(),
        ]);
        $this->createIndex(
            'rule_id',
            'rule_retailers',
            'rule_id'
        );
        $this->createIndex(
            'retailer_id',
            'rule_retailers',
            'retailer_id'
        );
        $this->addForeignKey(
            'rule_retailers_rel_rules',
            'rule_retailers',
            'rule_id',
            'rules',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'rule_retailers_rel_retailers',
            'rule_retailers',
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
        echo "m180828_134059_create_table_rule_retailers cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_134059_create_table_rule_retailers cannot be reverted.\n";

        return false;
    }
    */
}
