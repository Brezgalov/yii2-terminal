<?php

use yii\db\Migration;

/**
 * Class m180828_131822_create_table_retailers
 */
class m180828_131822_create_table_retailers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('retailers', [
            'id'    => $this->primaryKey(),
            'name'  => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_131822_create_table_retailers cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_131822_create_table_retailers cannot be reverted.\n";

        return false;
    }
    */
}
