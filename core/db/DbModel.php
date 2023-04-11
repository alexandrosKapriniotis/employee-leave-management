<?php

namespace app\core\db;

use app\core\Application;
use app\core\Model;
use PDO;

abstract class DbModel extends Model
{

    abstract public static function tableName(): string;
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
        $tableName  = static::tableName();
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

    public static function prepare($sql): \PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    /**
     * @param $where
     * @return DbModel|false|object|\stdClass|null
     */
    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(function ($attr) {
            return "$attr = :$attr";
        }, $attributes));

        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();

        return $statement->fetchObject(static::class);
    }

    public static function findAll()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName LIMIT 20");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}