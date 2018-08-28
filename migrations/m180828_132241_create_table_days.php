<?php

use yii\db\Migration;

/**
 * Class m180828_132241_create_table_days
 */
class m180828_132241_create_table_days extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('days', [
            'id'    => $this->primaryKey(),
            'date'  => $this->date()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_132241_create_table_days cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_132241_create_table_days cannot be reverted.\n";

        return false;
    }
    */
}
