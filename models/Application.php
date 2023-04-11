<?php

namespace app\models;

use app\core\db\DbModel;

class Application extends DbModel
{
    protected $date_from;
    protected $date_to;
    protected $reason;
    protected $status;

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
            'reason'
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
}