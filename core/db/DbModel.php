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
     * @param array $model
     * @return DbModel|false|object|\stdClass|null
     */
    public function save(array $model)
    {
        $tableName  = static::tableName();
        $attributes = $this->attributes();
        $params = array_map(function ($attr) {
            return ":$attr";
        }, $attributes);

        $statement = self::prepare("INSERT INTO $tableName (" . implode(",", $attributes) . ") 
                VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $model[$attribute]);
        }
        $statement->execute();

        return self::findById(Application::$app->db->pdo->lastInsertId());
    }

    /**
     * @param array $where
     * @param array $update
     * @return bool
     */
    public function update(array $where, array $update): bool
    {
        $tableName  = static::tableName();
        $whereSql   = self::prepareStatementAttributes($where);
        $setSql = self::prepareUpdateStatementAttributes($update);

        $statement = self::prepare("UPDATE $tableName SET $setSql WHERE $whereSql");
        foreach (array_merge($update, $where) as $key => $item) {
            $statement->bindValue(":$key", $item);
        }

        return $statement->execute();
    }

    /**
     * @param array $attributes
     * @return string
     */
    public function prepareUpdateStatementAttributes(array $attributes): string
    {
        $attributeKeys = array_keys($attributes);

        return implode(",", array_map(function ($attr) {
            return "$attr = :$attr";
        }, $attributeKeys));
    }

    /**
     * @param array $attributes
     * @return string
     */
    public function prepareStatementAttributes(array $attributes): string
    {
        $attributeKeys = array_keys($attributes);

        return implode(" AND ", array_map(function ($attr) {
            return "$attr = :$attr";
        }, $attributeKeys));
    }

    /**
     * @param $id
     * @param array $update
     * @return bool
     */
    public static function findByIdAndUpdate($id, array $update): bool
    {
        $model = self::findById($id);

        return $model->update(['id' => $id], $update);
    }

    /**
     * @param int $primaryKey
     * @return bool
     */
    public static function delete(int $primaryKey): bool
    {
        $tableName  = static::tableName();
        $statement  = self::prepare("DELETE FROM $tableName WHERE ".self::primaryKey()." = :primary_key");
        $statement->bindValue('primary_key', $primaryKey);
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

    /**
     * @param $id
     * @return DbModel|false|object|\stdClass|null
     */
    public static function findById($id)
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE id = :id");
        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement->fetchObject(static::class);
    }

    /**
     * @param array $where
     * @param string $select
     * @param int $order
     * @param string $direction
     * @return array|false
     */
    public static function findMany(array $where, string $select = '*', int $order = 1, string $direction = 'ASC')
    {
        $tableName = static::tableName();

        $attributes = array_keys($where);
        $sql = implode("AND", array_map(function ($attr) {
            return "$attr = :$attr";
        }, $attributes));

        $order = " ORDER BY :order ";
        $order .= ($direction === 'ASC') ? " ASC" : "DESC";
        $statement = self::prepare("SELECT $select FROM $tableName WHERE $sql $order");

        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->bindValue(':order', $order, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findAll()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName LIMIT 20");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function pluck($key, $data) {
        return array_reduce($data, function($result, $array) use($key) {
            isset($array[$key]) && $result[] = $array[$key];
            return $result;
        }, array());
    }
}