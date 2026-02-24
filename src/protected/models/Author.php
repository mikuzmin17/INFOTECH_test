<?php

class Author extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'author';
    }

    public function rules(): array
    {
        return [
            ['last_name', 'required'],
            ['last_name', 'length', 'max' => 255],
            ['last_name', 'filter', 'filter' => 'strip_tags'],
        ];
    }

    public function relations(): array
    {
        return [
            'books' => [self::MANY_MANY, 'Book', 'book_author(author_id, book_id)'],
            'bookAuthors' => [self::HAS_MANY, 'BookAuthor', 'author_id'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Full name',
        ];
    }

    public static function getTopAuthorsByYear(int $year): array
    {
        $sql = "
            SELECT
                a.id,
                a.last_name,
                COUNT(DISTINCT b.id) as books_count
            FROM author a
            JOIN book_author ba ON a.id = ba.author_id
            JOIN book b ON ba.book_id = b.id
            WHERE b.year = :year
            GROUP BY a.id, a.last_name
            ORDER BY books_count DESC
            LIMIT 10;
        ";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':year', $year, PDO::PARAM_INT);

        return $command->queryAll();
    }
}
