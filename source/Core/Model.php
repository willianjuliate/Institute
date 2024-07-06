<?php

namespace Source\Core;

use PDOException;
use PDOStatement;
use Source\Utils\Connection;
use stdClass;

use Source\Utils\Message;

abstract class Model
{
    /**
     * @var stdClass|null
     */
    protected ?stdClass $data;
    /**
     * @var PDOException|null
     */
    protected ?PDOException $fail;
    /**
     * @var Message|null
     */
    protected ?Message $message;

    /**
     *
     */
    public function __construct()
    {
        $this->message = new Message();
    }

    /**
     * @param string $name
     * @param $value
     * @return void
     */
    public function __set(string $name, $value): void
    {
        if (empty($this->data)) {
            $this->data = new stdClass();
        }
        $this->data->$name = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        return ($this->data->$name ?? null);
    }

    /**
     * @return stdClass|null
     */
    public function data(): ?stdClass
    {
        return $this->data;
    }

    /**
     * @return PDOException|null
     */
    public function fail(): ?\PDOException
    {
        return $this->fail;
    }

    /**
     * @return Message|null
     */
    public function message(): ?Message
    {
        return $this->message;
    }

    /**
     * @param string $entity
     * @param array $data
     * @return int|null
     */
    protected function create(string $entity, array $data): ?int
    {
        try {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            $smt = Connection::instance()->prepare("INSERT INTO {$entity} ($columns) VALUES ({$values})");
            $smt->execute($this->filter($data));

            return Connection::instance()->lastInsertId();
        } catch (PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param string $select
     * @param array|string|null $params
     * @return PDOStatement|null
     */
    protected function read(string $select, array|string $params = null): ?PDOStatement
    {
        try {
            $stmt = Connection::instance()->prepare($select);
            if ($params) {
                parse_str($params, $params);
                foreach ($params as $key => $value) {
                    if ($key == 'limit' || $key == 'offset') {
                        $stmt->bindValue(":{$key}", $value, \PDO::PARAM_INT);
                    } else {
                        $stmt->bindValue(":{$key}", $value, \PDO::PARAM_STR);
                    }
                }
            }
            $stmt->execute();

            return $stmt;
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param string $entity
     * @param array $data
     * @param string $terms
     * @param array|string $params
     * @return int|null
     */
    protected function update(string $entity, array $data, string $terms, array|string $params): ?int
    {
        try {
            $dateSet = [];
            foreach ($data as $bind => $value) {
                $dateSet[] = "{$bind} = :{$bind}";
            }
            $dateSet = implode(", ", $dateSet);
            parse_str($params, $params);

            $stmt = Connection::instance()->prepare("UPDATE {$entity} SET {$dateSet} WHERE {$terms}");
            $stmt->execute($this->filter(array_merge($data, $params)));

            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @param string $entity
     * @param string $terms
     * @param array|string $params
     * @return int|null
     */
    protected function delete(string $entity, string $terms, array|string $params): ?int
    {
        try {
            $stmt = Connection::instance()->prepare("DELETE FROM {$entity} WHERE {$terms}");
            parse_str($params, $params);
            $stmt->execute($params);

            return ($stmt->rowCount() ?? 1);
        } catch (\PDOException $exception) {
            $this->fail = $exception;
            return null;
        }
    }

    /**
     * @return array|null
     */
    protected function safe(): ?array
    {
        $safe = (array)$this->data;
        foreach (static::$safe as $unset) {
            unset($safe[$unset]);
        }
        return $safe;
    }

    /**
     * @param array $data
     * @return array|null
     */
    private function filter(array $data): ?array
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
        }
        return $filter;
    }

    /**
     * @return bool
     */
    protected function required(): bool
    {
        $data = (array)$this->data();
        foreach (static::$required as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }
        return true;
    }

}