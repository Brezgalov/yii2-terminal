<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `rule_retailers`.
 */
class m180830_081323_drop_rule_retailers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('rule_retailers');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180830_081323_drop_rule_retailers_table cannot be reverted.\n";

        return false;
    }
}
