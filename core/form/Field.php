<?php

namespace app\core\form;

use ReflectionClass;

class Field extends BaseField
{
    const TYPE_TEXT = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_EMAIL = 'email';

    public $readOnly = false;

    /**
     * @param $model
     * @param $attribute
     */
    public function __construct($model, $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    public function renderInput(): string
    {
        $readOnly = $this->readOnly ? 'readonly' : '';
        return sprintf('<input type="%s" class="form-control%s" name="%s" value="%s" %s>',
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
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
}