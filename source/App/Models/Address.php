<?php

namespace Source\App\Models;

use PDO;
use Source\Core\Model;

/**
 * @property string $state;
 * @property string $city;
 * @property string $district;
 * @property string $street;
 * @property string $number;
 * @property string $zip_code;
 * @property int|null $id
 * @property int $id_manager
 */
class Address extends Model
{
    protected static array $safe = ["id", "created_at", "updated_at"];
    protected static array $required = ['id_manager', 'state', 'city', 'district', 'street', 'number', 'zip_code'];
    protected static string $entity = "address";


    public function bootstrap(
        int $id_manager,
        string $state,
        string $city,
        string $district,
        string $street,
        string $number,
        string $zip_code
    ): Address {
        $this->id_manager = $id_manager;
        $this->state = $state;
        $this->city = $city;
        $this->district = $district;
        $this->street = $street;
        $this->number = $number;
        $this->zip_code = $zip_code;

        return $this;
    }

    public function find(string $terms, string $params, string $columns = "*"): ?Address
    {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() or !$find->rowCount()) {
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }

    public function findById(int $id, string $columns = '*'): ?Address
    {
        return $this->find("id = :id", "id={$id}", $columns);
    }

    public function findByIdManager(int $id_manager, string $columns = '*'): ?Address
    {
        return $this->find("id_manager = :id_manager", "id_manager={$id_manager}", $columns);
    }

    public function findByManager(string $email, string $columns = '*'): ?Address
    {
        $id_manager = manager()->findByEmail($email)->id;
        return $this->find("id_manager = :id_manager", "id_manager={$id_manager}", $columns);
    }

    public function created(): ?Address
    {
        if (!$this->required()) {
            $this->message()->warning(
                "Os seguintes campos podem estar faltando:" . implode(', ', self::$required));
            return null;
        }

        $this->id = $this->create(self::$entity, $this->safe());

        if ($this->fail()) {
            $this->message->error("Erro ao cadastrar o endereço, verifique os dados");
            return null;
        }

        $this->data = $this->findById($this->id)->data();

        return $this;

    }

    public function all(int $limit = 30, int $offset = 0, string $columns = '*'): ?array
    {
        $all = $this->read(
            "SELECT {$columns} FROM " . self::$entity . " LIMIT :limit OFFSET :offset",
            "limit={$limit}&offset={$offset}"
        );
        if ($this->fail() || !$all->rowCount()) {
            return null;
        }

        return $all->fetchAll(PDO::FETCH_CLASS, __CLASS__);
    }
}