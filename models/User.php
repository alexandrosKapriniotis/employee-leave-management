<?php

namespace app\models;

use app\core\Application as coreApplication;
use app\core\db\DbModel;
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
     * @return DbModel|false|object|\stdClass|null
     */
    public function save(array $model)
    {
        $model['password'] = password_hash($this->password, PASSWORD_DEFAULT);

        return parent::save($model);
    }

    /**
     * @return array[]
     */
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

    /** Get user's applications
     *
     * @return array|false
     */
    public function getMyApplications()
    {
        return Application::findMany(['user_id' => coreApplication::$app->user->id], '*', 7, 'DESC');
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function notifyUser(int $id, array $data): bool
    {
        $user = self::findById($id);

        if ($user) {
            $subject  = $data['subject'];

            $body     =  "Dear employee, your supervisor has ".$data['application_status']." your application\n
                            submitted on ".$data['submission_date'];
            $headers = 'From: info@employeeportal.space' . "\r\n" .
                'Reply-To: info@employeeportal.space' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            return mail($user->email, $subject, $body, $headers);
        }
        return false;
    }

    /**
     * @return array|false
     */
    public static function getAdminUsers()
    {
        return self::findMany(['user_type' => 'admin'], 'email');
    }

    /**
     * @return string
     */
    public static function getAdminEmails(): string
    {
        $admins = self::findMany(['user_type' => 'admin'], 'email');

        return implode(',', self::pluck('email', $admins));
    }

    /**
     * @param Application $application
     * @return bool
     */
    public static function notifyAdmins(Application $application): bool
    {
        $adminEmails = self::getAdminEmails();
        $subject  = 'New vacation request';
        $approveButton = "<a href=\"".coreApplication::$app->appUrl."/applications/".$application->id."/status/approved\">Approve</a>";
        $rejectButton = "<a href=\"".coreApplication::$app->appUrl."/applications/".$application->id."/status/rejected\">Reject</a>";
        $body     =  "Dear supervisor, employee ".coreApplication::$app->user->getDisplayName()." requested for some time off, starting on ".
            $application->getDateFrom()." and ending on ".$application->getDateTo().", stating the reason: <strong>".$application->getReason()."</strong>\r\n Click on one of the below
            links to approve or reject the application: ".$approveButton." - ".$rejectButton;
        $headers = "From: ".coreApplication::$app->emailFrom."\r\n".
            "Reply-To: ".coreApplication::$app->emailFrom."\r\n".
            "X-Mailer: PHP/".phpversion();
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        return mail($adminEmails, $subject, $body, $headers);
    }
}