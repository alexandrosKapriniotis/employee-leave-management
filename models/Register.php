<?php

namespace app\models;

use app\core\Model;

class Register extends Model
{
    public $firstName = '';
    public $lastName = '';
    public $email = '';
    protected $userType = 'employee';
    public $password = '';
    public $confirmPassword = '';

    public function register()
    {
        echo "Creating new user";
    }

    public function rules()
    {
        return [
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => '6'], [self::RULE_MAX, 'max' => '12']],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }
}