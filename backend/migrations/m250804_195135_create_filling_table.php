<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%filling}}`.
 */
class m250804_195135_create_filling_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%filling}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'volume' => $this->integer()->notNull(),
            'tank_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            "idx-filling-tank_id",
            "{{%filling}}",
            'tank_id'
        );

        $this->addForeignKey(
            "fk-filling-tank_id",
            "{{%filling}}",
            'tank_id',
            '{{%tank}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            "fk-filling-tank_id",
            "{{%filling}}"
        );
        $this->dropIndex(
            "idx-filling-tank_id",
            "{{%filling}}"
        );

        $this->dropTable('{{%filling}}');
    }
}
