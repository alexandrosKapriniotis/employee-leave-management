<?php

namespace app\core\form;

class SelectField extends BaseField
{
    public $options;

    /**
     * @param $model
     * @param $attribute
     * @param $options
     */
    public function __construct($model, $attribute, $options)
    {
        $this->options = $options;
        parent::__construct($model, $attribute);
    }


    /**
     * @return string
     */
    public function renderInput(): string
    {
        return sprintf('<select class="form-select%s" name="%s">%s</select>',
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->getOptions()
        );
    }

    /**
     * @return string
     */
    public function getOptions(): string
    {
        $optionsHtml = '<option selected>Please select a user type</option>';
        foreach($this->options as $option){
            $optionsHtml .= "<option value=".strtolower($option).">$option</option>";
        }
        return $optionsHtml;
    }
}