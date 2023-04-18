<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class LoginForm extends Model
{
    public $email = '';
    public $password = '';

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

    /**
     * @return bool
     */
    public function login(): bool
    {
        $user = User::findOne(['email' => $this->email]);

        if (!$user) {
            $this->addError('email', 'User not found');
            return false;
        }

        if (!password_verify($this->password, $user->getPassword())) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        return Application::$app->login($user);
    }

    /**
     * @return array
     */
    public function labels(): array
    {
        return [
            'email'      => 'Email',
            'password'   => 'Password',
        ];
    }
}