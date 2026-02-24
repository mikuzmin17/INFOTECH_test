<?php

class m250308_000002_create_book_author_tables extends CDbMigration
{
    public function safeUp(): void
    {
        $schema = $this->dbConnection->schema;
        if ($schema->getTable('book_author', true) !== null) {
            $this->dropTable('book_author');
        }
        if ($schema->getTable('book', true) !== null) {
            $this->dropTable('book');
        }
        if ($schema->getTable('author', true) !== null) {
            $this->dropTable('author');
        }

        $this->createTable('author', [
            'id' => 'pk',
            'last_name' => 'string NOT NULL',
			'first_name' => 'string NOT NULL',
			'middle_name' => 'string',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->createIndex('idx_author_name', 'author', ['last_name', 'first_name'], true);

        $this->createTable('book', [
            'id' => 'pk',
            'isbn' => 'varchar(50) DEFAULT ""',
            'title' => 'varchar(255) NOT NULL',
            'year' => 'integer NOT NULL',
            'description' => 'text',
            'image_url' => 'varchar(2048) DEFAULT ""',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->createIndex('idx_book_year', 'book', ['isbn', 'title']);

        $this->createTable('book_author', [
            'id' => 'pk',
            'book_id' => 'integer NOT NULL',
            'author_id' => 'integer NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->createIndex('idx_book_author_unique', 'book_author', 'book_id, author_id', true);
        $this->addForeignKey('fk_book_author_book', 'book_author', 'book_id', 'book', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_book_author_author', 'book_author', 'author_id', 'author', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown(): void
    {
        $this->dropTable('book_author');
        $this->dropTable('book');
        $this->dropTable('author');
    }
}
