<?php

namespace app\models;

use app\core\db\DbModel;

class Application extends DbModel
{
    protected $date_from;
    protected $date_to;
    protected $reason;
    protected $status;
    private $user_id;

    public static function tableName(): string
    {
        return 'applications';
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'date_from',
            'date_to',
            'reason',
            'user_id'
        ];
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'date_from' => [self::RULE_REQUIRED],
            'date_to'   => [self::RULE_REQUIRED],
            'reason'    => [self::RULE_REQUIRED]
        ];
    }

    /**
     * @return array
     */
    public function labels(): array
    {
        return [
            'date_from' => 'Date from',
            'date_to'  => 'Date to',
            'reason'      => 'Reason'
        ];
    }

    /**
     * @return mixed
     */
    public function getDateFrom()
    {
        return $this->date_from;
    }

    /**
     * @param mixed $date_from
     */
    public function setDateFrom($date_from)
    {
        $this->date_from = $date_from;
    }

    /**
     * @return mixed
     */
    public function getDateTo()
    {
        return $this->date_to;
    }

    /**
     * @param mixed $date_to
     */
    public function setDateTo($date_to)
    {
        $this->date_to = $date_to;
    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param mixed $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param $date_from
     * @param $date_to
     * @return float
     */
    public static function getDaysRequested($date_from, $date_to): float
    {
        $from_date = strtotime($date_from);
        $to_date = strtotime($date_to);
        $datediff = $to_date - $from_date;

        return round($datediff / (60 * 60 * 24));
    }
}