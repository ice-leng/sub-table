<?php

declare(strict_types=1);

namespace Lengbin\SubDatabase\SubTable;

use PDO;

abstract class AbstractSubTable
{
    private PDO $pdo;

    private string $key;

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * @param PDO $pdo
     * @return self
     */
    public function setPdo(PDO $pdo): self
    {
        $this->pdo = $pdo;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return self
     */
    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    abstract public function suffix(): string;

    public function createSubTable(string $table): bool
    {
        $showTableSql = " show create table {$table}";
        $result = $this->getPdo()->query($showTableSql)->fetch();
        $createTableSql = str_replace($table, "{$table}_{$this->suffix()}", $result['Create Table']);
        $statement = $this->getPdo()->prepare($createTableSql);
        $statement->execute();
        return true;
    }
}