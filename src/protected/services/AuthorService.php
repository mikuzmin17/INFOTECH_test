<?php

class AuthorService
{
    public function loadModel(int $id): Author
    {
        return Author::model()->with('books')->findByPk($id) ?: throw new CHttpException(404, 'Author not found.');
    }
}
