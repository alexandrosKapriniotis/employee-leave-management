<?php

namespace app\core\form;

class TextAreaField extends BaseField
{
    /**
     * @return string
     */
    public function renderInput(): string
    {
        return sprintf('<textarea class="form-control%s" name="%s">%s</textarea>',
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->getValue()
        );
    }
}