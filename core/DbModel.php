<?php

namespace app\core;

abstract class DbModel extends Model
{

    abstract public function tableName(): string;
    public static function primaryKey(): string
    {
        return 'id';
    }
    abstract public function attributes(): array;

    /**
     * @return bool
     */
    public function save(): bool
    {
        $tableName  = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(function ($attr) {
            return ":$attr";
        }, $attributes);

        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();

        return true;
    }

    public function prepare($sql): \PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }


}