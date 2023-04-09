<?php

namespace app\core\form;

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
     * @param $attribute
     * @return Field
     */
    public function field($model, $attribute): Field
    {
        return new Field($model, $attribute);
    }

    /**
     * @param $model
     * @param $attribute
     * @param $options
     * @return SelectField
     */
    public function selectField($model, $attribute, $options): SelectField
    {
        return new SelectField($model, $attribute, $options);
    }
}