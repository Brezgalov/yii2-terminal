<?php

use yii\db\Migration;

/**
 * Class m180828_132547_create_table_work_shifts
 */
class m180828_132547_create_table_work_shifts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('work_shifts', [
            'id'        => $this->primaryKey(),
            'day_id'    => $this->integer()->notNull(),
            'start'     => $this->integer()->notNull(),
            'end'       => $this->integer()->notNull(),
        ]);
         $this->createIndex(
            'work_shift_days',
            'work_shifts',
            'day_id'
        );
        $this->addForeignKey(
            'work_shifts_rel_days',
            'work_shifts',
            'day_id',
            'days',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180828_132547_create_table_work_shifts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180828_132547_create_table_work_shifts cannot be reverted.\n";

        return false;
    }
    */
}
