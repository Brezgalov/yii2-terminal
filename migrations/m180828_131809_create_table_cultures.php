<?php

use yii\db\Migration;

/**
 * Class m180828_131809_create_table_cultures
 */
class m180828_131809_create_table_cultures extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('cultures', [
            'id'    => $this->primaryKey(),
            'name'  => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_131809_create_table_cultures cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_131809_create_table_cultures cannot be reverted.\n";

        return false;
    }
    */
}
