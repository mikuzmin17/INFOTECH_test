<?php

class User extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName(): string
    {
        return 'user';
    }

    public function rules(): array
    {
        return [
            ['email, password_hash', 'required', 'on' => 'insert'],
            ['email', 'email'],
            ['email', 'length', 'max' => 255],
            ['password_hash', 'length', 'max' => 255],
            ['email', 'unique'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
            'password_hash' => 'Password hash',
        ];
    }

    public function beforeSave(): bool
    {
        $now = time();
        if ($this->isNewRecord) {
            $this->created_at = $now;
        }
        $this->updated_at = $now;
        return parent::beforeSave();
    }

    public function setPassword($password): void
    {
        $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
    }

    public function validatePassword($password): bool
    {
        return password_verify($password, $this->password_hash);
    }
}
