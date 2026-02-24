<?php

class Subscription extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'subscription';
    }

    public function rules(): array
    {
        return [
            ['author_id, phone', 'required'],
            ['author_id', 'numerical', 'integerOnly' => true],
            ['phone', 'length', 'max' => 20],
            ['phone', 'match', 'pattern' => '/^\d{10,15}$/', 'message' => 'Enter a valid phone number.'],
            ['phone', 'validateUniqueSubscription'],
        ];
    }

    public function relations(): array
    {
        return [
            'author' => [self::BELONGS_TO, 'Author', 'author_id'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Phone',
        ];
    }

    public function beforeValidate()
    {
        if ($this->phone !== null) {
            $this->phone = preg_replace('/\D+/', '', $this->phone);
        }
        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
        }
        return parent::beforeSave();
    }

    public function validateUniqueSubscription($attribute, $params): void
    {
        if ($this->hasErrors()) {
            return;
        }
        $exists = self::model()->exists(
            'author_id = :authorId AND phone = :phone',
            [':authorId' => $this->author_id, ':phone' => $this->phone],
        );
        if ($exists) {
            $this->addError($attribute, 'You are already subscribed to this author.');
        }
    }

    public static function collectPhonesByAuthorIds(array $authorIds): array
    {
        $authorIds = array_unique(array_map('intval', $authorIds));
        if (empty($authorIds)) {
            return [];
        }

        $criteria = new CDbCriteria();
        $criteria->select = 'phone';
        $criteria->addInCondition('author_id', $authorIds);
        $criteria->group = 'phone';
        $subscriptions = self::model()->findAll($criteria);
        $phones = [];
        foreach ($subscriptions as $subscription) {
            $phones[] = $subscription->phone;
        }
        return $phones;
    }
}
