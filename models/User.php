<?php

namespace app\models;

use app\core\DbModel;

class User extends DbModel
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    protected $user_type = 'employee';
    public $password = '';
    public $confirmPassword = '';

    /**
     * Declare the database table for the model
     * @return string
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => '6'], [self::RULE_MAX, 'max' => '12']],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name',
            'last_name',
            'email',
            'password',
            'user_type'
        ];
    }

    /**
     * @return array
     */
    public function labels(): array
    {
        return [
            'first_name' => 'First Name',
            'last_name'  => 'Last Name',
            'email'      => 'Email',
            'user_type'  => 'User Type',
            'password'   => 'Password',
            'confirmPassword' => 'Confirm Password'
        ];
    }
}