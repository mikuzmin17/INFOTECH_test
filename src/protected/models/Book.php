<?php

class Book extends CActiveRecord
{
    public $authorIds = [];

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'book';
    }

    public function rules(): array
    {
        return [
            ['title, year, isbn, description, image_url', 'required'],
            ['year', 'numerical', 'integerOnly' => true, 'min' => 0],
            ['isbn', 'length', 'max' => 50],
            ['title', 'length', 'max' => 255],
            ['image_url', 'length', 'max' => 2048],
            ['image_url', 'url', 'allowEmpty' => true],
            ['authorIds', 'safe'],
            ['authorIds', 'validateAuthors'],
            ['description, title, isbn, image_url', 'filter', 'filter' => 'strip_tags'],
        ];
    }

    public function relations(): array
    {
        return [
            'authors' => [self::MANY_MANY, 'Author', 'book_author(book_id, author_id)'],
            'bookAuthors' => [self::HAS_MANY, 'BookAuthor', 'book_id'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'isbn' => 'ISBN',
            'title' => 'Title',
            'year' => 'Release year',
            'description' => 'Description',
            'image_url' => 'Cover URL',
            'authorIds' => 'Authors',
        ];
    }

    public function saveWithAuthors(array $authorIds): bool
    {
        $authorIds = $this->normalizeAuthorIds($authorIds);
        $this->authorIds = $authorIds;
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $isNew = $this->isNewRecord;
            if (!$this->save()) {
                $transaction->rollback();
                return false;
            }

            $this->syncAuthors($authorIds);
            $transaction->commit();

            if ($isNew) {
                BookNotifier::notifyNewBook($this, $authorIds);
            }

            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            $this->addError('authorIds', 'Unable to save book authors.');
            return false;
        }
    }

    public static function getAvailableYears(): array
    {
        return Yii::app()->db->createCommand()
            ->selectDistinct('year')
            ->from('book')
            ->order('year')
            ->queryColumn();
    }

    protected function normalizeAuthorIds(array $authorIds): array
    {
        $clean = [];
        foreach ($authorIds as $authorId) {
            $authorId = (int) $authorId;
            if ($authorId > 0) {
                $clean[$authorId] = $authorId;
            }
        }
        return array_values($clean);
    }

    protected function syncAuthors(array $authorIds): void
    {
        $existing = [];
        foreach ($this->bookAuthors as $bookAuthor) {
            $existing[] = (int) $bookAuthor->author_id;
        }

        $toDelete = array_diff($existing, $authorIds);
        $toAdd = array_diff($authorIds, $existing);

        if (!empty($toDelete)) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('author_id', $toDelete);
            $criteria->addCondition('book_id = :bookId');
            $criteria->params[':bookId'] = $this->id;
            BookAuthor::model()->deleteAll($criteria);
        }

        foreach ($toAdd as $authorId) {
            $link = new BookAuthor();
            $link->book_id = $this->id;
            $link->author_id = (int) $authorId;
            if (!$link->save()) {
                throw new CException('Failed to save book author link.');
            }
        }
    }

    public function validateAuthors($attribute, $params): void
    {
        if (empty($this->authorIds)) {
            $this->addError($attribute, 'Select at least one author.');
        }
    }
}
