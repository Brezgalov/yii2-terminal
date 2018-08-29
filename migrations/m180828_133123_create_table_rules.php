<?php

use yii\db\Migration;

/**
 * Class m180828_133123_create_table_rules
 */
class m180828_133123_create_table_rules extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rules', [
            'id'        => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_133123_create_table_rules cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_133123_create_table_rules cannot be reverted.\n";

        return false;
    }
    */
}
