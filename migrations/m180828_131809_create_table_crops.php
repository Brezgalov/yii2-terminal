<?php

use yii\db\Migration;

/**
 * Class m180828_131809_create_table_crops
 */
class m180828_131809_create_table_crops extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('crops', [
            'id'    => $this->primaryKey(),
            'name'  => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_131809_create_table_crops cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_131809_create_table_crops cannot be reverted.\n";

        return false;
    }
    */
}
