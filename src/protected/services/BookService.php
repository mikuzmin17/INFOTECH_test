<?php

class BookService
{
    public function loadModel(int $id): Book
    {
        return Book::model()->with('authors')->findByPk($id) ?: throw new CHttpException(404, 'Book not found.');
    }

    public function getAuthorsList(): array
    {
        return CHtml::listData(Author::model()->findAll(['order' => 'name']), 'id', 'name');
    }
    
    public function validate(Book $model): Book
    {
        if (isset($_POST['Book'])) {
            $model->attributes = $_POST['Book'];
            $model->authorIds = $_POST['Book']['authorIds'] ?? [];

            return $model;
        }

        return $model;
    }
}
