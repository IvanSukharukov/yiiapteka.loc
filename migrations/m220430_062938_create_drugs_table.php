<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%drugs}}`.
 */
class m220430_062938_create_drugs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%drugs}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%drugs}}');
    }
}
