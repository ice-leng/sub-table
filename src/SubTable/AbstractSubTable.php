<?php

declare(strict_types=1);

namespace Lengbin\SubDatabase\SubTable;

use PDO;

abstract class AbstractSubTable
{
    private PDO $pdo;

    private string $key;

    private string $table;

    private string $tablePrefix;

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     * @return AbstractSubTable
     */
    public function setTable(string $table): AbstractSubTable
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string
     */
    public function getTablePrefix(): string
    {
        return $this->tablePrefix;
    }

    /**
     * @param string $tablePrefix
     * @return AbstractSubTable
     */
    public function setTablePrefix(string $tablePrefix): AbstractSubTable
    {
        $this->tablePrefix = $tablePrefix;
        return $this;
    }

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

    public function getSubTable(): string
    {
        return  $this->getTablePrefix() . $this->getTable() . '_' . $this->suffix();
    }

    public function createSubTable(): bool
    {
        $table = $this->getTablePrefix() . $this->getTable();
        $showTableSql = " show create table {$table}";
        $result = $this->getPdo()->query($showTableSql)->fetch();
        $createTableSql = str_replace($table, "{$table}_{$this->suffix()}", $result['Create Table']);
        $statement = $this->getPdo()->prepare($createTableSql);
        $statement->execute();
        return true;
    }
}