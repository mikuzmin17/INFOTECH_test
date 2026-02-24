<?php

class m250308_000001_create_user_table extends CDbMigration
{
    public function safeUp(): void
    {
        $this->createTable('user', [
            'id' => 'pk',
            'email' => 'string NOT NULL',
            'password_hash' => 'string NOT NULL',
            'created_at' => 'integer NOT NULL',
            'updated_at' => 'integer NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->createIndex('idx_user_email', 'user', 'email', true);

        $password = getenv('DEFAULT_USER_PASSWORD') ?: 'Yii1User@';
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $now = time();
        $this->insert('user', [
            'email' => getenv('DEFAULT_USER_EMAIL') ?: 'user@yii1.ru',
            'password_hash' => $hash,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function safeDown(): void
    {
        $this->dropTable('user');
    }
}
