<?php

namespace app\core\form;

use app\core\db\DbModel;
use ReflectionClass;

class Field extends BaseField
{
    const TYPE_TEXT = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_EMAIL = 'email';
    const TYPE_DATE = 'date';
    const TYPE_HIDDEN = 'hidden';
    public $readOnly = false;

    /**
     * @param $model
     * @param string $attribute
     * @param string $value
     */
    public function __construct($model,string $attribute, string $value = '')
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute, $value);
    }

    public function renderInput(): string
    {
        $readOnly = $this->readOnly ? 'readonly' : '';
        return sprintf('<input type="%s" class="form-control%s" name="%s" value="%s" %s>',
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->getValue(),
            $readOnly
        );
    }

    /**
     * @return $this
     */
    public function readOnly(): Field
    {
        $this->readOnly = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function passwordField(): Field
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    /**
     * @return $this
     */
    public function emailField(): Field
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    /**
     * @return $this
     */
    public function dateField(): Field
    {
        $this->type = self::TYPE_DATE;
        return $this;
    }

    /**
     * @return $this
     */
    public function hiddenField(): Field
    {
        $this->type = self::TYPE_HIDDEN;
        return $this;
    }
}