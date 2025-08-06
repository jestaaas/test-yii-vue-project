<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tank}}`.
 */
class m250804_194522_create_tank_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tank}}', [
            'id' => $this->primaryKey(),
            'current_volume' => $this->integer()->notNull()->defaultValue(0),
        ]);

        for($i = 1; $i <= 5; $i++) {
            $this->insert('{{%tank}}', ['current_volume' => 0]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tank}}');
    }
}
