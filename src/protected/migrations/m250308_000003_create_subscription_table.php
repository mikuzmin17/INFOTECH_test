<?php

class m250308_000003_create_subscription_table extends CDbMigration
{
    public function safeUp(): void
    {
        $this->createTable('subscription', [
            'id' => 'pk',
            'author_id' => 'integer NOT NULL',
            'phone' => 'string NOT NULL',
            'created_at' => 'integer NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->createIndex('idx_subscription_unique', 'subscription', 'author_id, phone', true);
        $this->addForeignKey('fk_subscription_author', 'subscription', 'author_id', 'author', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown(): void
    {
        $this->dropTable('subscription');
    }
}
