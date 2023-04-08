<?php

namespace app\core\form;

class Field
{
    const TYPE_TEXT = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_EMAIL = 'email';
    const TYPE_NUMBER = 'email';

    public $type;
    public $model;
    public $attribute;

    /**
     * @param $model
     * @param $attribute
     */
    public function __construct($model, $attribute)
    {
        $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        return sprintf('
            <div class="form-group mb-4">
                <label class="mb-2">%s</label>
                <input type="%s" name="%s" value="%s" class="form-control%s">
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            $this->attribute,
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->getFirstError($this->attribute)
        );
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