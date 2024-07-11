<?php

namespace Source\App\Models;

use PDO;
use Source\Core\Model;

/**
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $passwd
 * @property string|null $document
 * @property int|null $id
 */
class Manager extends Model
{
    protected static array $safe = ["id", "created_at", "updated_at"];
    protected static array $required = ["first_name", "last_name", "email", "passwd"];
    protected static string $entity = "manager";

    public function bootstrap(
        string $firstName,
        string $lastName,
        string $mail,
        string $passwd,
        string $document = ''
    ): Manager {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $mail;
        $this->passwd = $passwd;
        $this->document = $document;

        return $this;
    }

    public function find(string $terms, string $params, string $columns = "*"): ?Manager
    {
        $find = $this->read("SELECT {$columns} FROM " . self::$entity . " WHERE {$terms}", $params);
        if ($this->fail() or !$find->rowCount()) {
            return null;
        }

        return $find->fetchObject(__CLASS__);
    }

    public function findById(int $id, string $columns = '*'): ?Manager
    {
        return $this->find("id = :id", "id={$id}", $columns);
    }

    public function findByEmail(string $email, string $columns = '*'): ?Manager
    {
        return $this->find("email = :email", "email={$email}", $columns);
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

    public function created(): ?Manager
    {
        if (!$this->validateFields()) {
            return null;
        }
        $this->passwd = passwd($this->passwd);

        if ($this->findByEmail($this->email)) {
            $this->message->warning("O e-mail informado já está cadastrado");
            return null;
        }

        $this->id = $this->create(self::$entity, $this->safe());

        if ($this->fail()) {
            $this->message->error("Erro ao cadastrar, verifique os dados");
            return null;
        }

        $this->data = $this->findById($this->id)->data();

        return $this;
    }

    public function updated(): ?Manager
    {
        if (!$this->validateFields()) {
            return null;
        }

        $this->passwd = passwd($this->passwd);

        if ($this->find("email = :email AND id != :id", "email={$this->email}&id={$this->id}")) {
            $this->message->warning("O e-mail informado já está cadastrado");
            return null;
        }

        $this->update(self::$entity, $this->safe(), "id = :id", "id={$this->id}");

        if ($this->fail()) {
            $this->message->error("Erro ao atualizar, verifique os dados");
            return null;
        }

        $this->data = $this->findById($this->id)->data();

        return $this;
    }

    private function validateFields(): bool
    {
        if (!$this->required()) {
            $this->message->warning("Nome, Sobrenome, E-mail e Senha são obrigatórios");
            return false;
        }

        if (!is_email($this->email)) {
            $this->message->warning("O e-mail informado não tem um formato válido");
            return false;
        }

        if (!is_passwd($this->passwd)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("A senha deve ter entre {$min} e {$max} caracteres");
            return false;
        }

        return true;
    }

    public function destroy(): ?Manager
    {
        if (!empty($this->id)) {
            $this->delete(self::$entity, "id = :id", "id={$this->id}");
        }

        if ($this->fail()) {
            $this->message->error("Não foi possível remover o usuário");
            return null;
        }

        $this->data = null;
        return $this;
    }
}