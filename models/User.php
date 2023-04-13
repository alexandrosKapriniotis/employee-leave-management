<?php

namespace app\models;

use app\core\UserModel;

class User extends UserModel
{
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    private $user_type = 'employee';
    private $password = '';
    private $confirmPassword = '';

    /**
     * Declare the database table for the model
     * @return string
     */
    public static function tableName(): string
    {
        return 'users';
    }

    /**
     * @param array $model
     * @return bool
     */
    public function save(array $model): bool
    {
        $this->setPassword(password_hash($this->password, PASSWORD_DEFAULT));
        return parent::save($model);
    }

    public function rules(): array
    {
        return [
            'first_name' => [self::RULE_REQUIRED],
            'last_name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'user_type' => [self::RULE_REQUIRED],
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

    public function getDisplayName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * @return string
     */
    public function getUserType(): string
    {
        return $this->user_type;
    }

    /**
     * @param string $user_type
     */
    public function setUserType(string $user_type)
    {
        $this->user_type = $user_type;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    /**
     * @param string $confirmPassword
     */
    public function setConfirmPassword(string $confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;
    }
}