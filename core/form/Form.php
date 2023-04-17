<?php

namespace app\core\form;

use app\core\db\DbModel;

class Form
{
    /**
     * @param string $action
     * @param string $method
     * @param array $options
     * @return Form
     */
    public static function begin(string $action, string $method, array $options = []): Form
    {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        echo sprintf('<form action="%s" method="%s" %s>', $action, $method, implode(" ", $attributes));
        return new Form();
    }

    /**
     * @return void
     */
    public static function end()
    {
        echo '</form>';
    }

    /**
     * @param $model
     * @param string $attribute
     * @param string $value
     * @return Field
     */
    public function field($model,string $attribute, string $value = ''): Field
    {
        return new Field($model, $attribute, $value);
    }

    /**
     * @param $model
     * @param string $attribute
     * @param array $options
     * @param string $selected
     * @return SelectField
     */
    public function selectField($model,string $attribute,array $options,string $selected = ''): SelectField
    {
        return new SelectField($model, $attribute, $options, $selected);
    }

    /**
     * @param $model
     * @param $attribute
     * @return TextAreaField
     */
    public function textAreaField($model, $attribute): TextAreaField
    {
        return new TextAreaField($model, $attribute);
    }
}