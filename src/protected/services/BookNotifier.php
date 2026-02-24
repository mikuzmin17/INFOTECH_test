<?php

class BookNotifier
{
    public static function notifyNewBook(Book $book, array $authorIds)
    {
        $phones = Subscription::collectPhonesByAuthorIds($authorIds);
        if (empty($phones)) {
            return;
        }

        $message = sprintf(
            'New book added: \"%s\" (%d).',
            $book->title,
            (int) $book->year,
        );

        foreach ($phones as $phone) {
            Yii::app()->sms->send($phone, $message);
        }
    }
}
