<?php

namespace app\core\form;

use app\core\db\DbModel;
use app\core\Model;

abstract class BaseField
{
    public $type;
    public $model;
    public $attribute;
    private $value;

    /**
     * Field constructor.
     *
     * @param $model
     * @param string $attribute
     * @param string $value
     */
    public function __construct($model, string $attribute,string $value = '')
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->setValue($value);
    }

    public function __toString()
    {
        $label = $this->type !== 'hidden' ? sprintf('<label class="mb-2">%s</label>',$this->model->getLabel($this->attribute)) : '';

        return sprintf('<div class="form-group mb-2">
                %s
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>',
            $label,
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    abstract public function renderInput();
}