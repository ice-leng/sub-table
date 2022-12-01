<?php

declare(strict_types=1);

namespace Lengbin\SubDatabase\SubTable;

use PDO;

abstract class AbstractSubTable
{
    private string $key;

    private string $table;

    private string $tablePrefix = 't_';

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
        return $this->getTablePrefix() . $this->getTable() . '_' . $this->suffix();
    }

    public function hasTable(PDO $pdo, string $dbname, string $table): bool
    {
        $sql = "select * from information_schema.tables where table_schema = '{$dbname}' and table_name = '{$table}'";
        $result = $pdo->query($sql)->fetchAll();
        return count($result) > 0;
    }

    public function createSubTable(PDO $pdo, string $dbname, ?string $subTable = null): bool
    {
        $subTable = $subTable ?? $this->getSubTable();
        if ($this->hasTable($pdo, $dbname, $subTable)) {
            return false;
        }

        $table = $this->getTablePrefix() . $this->getTable();
        $showTableSql = "show create table {$table}";
        $result = $pdo->query($showTableSql)->fetch();
        $createTableSql = str_replace($table, $subTable, $result['Create Table']);
        $statement = $pdo->prepare($createTableSql);
        $statement->execute();
        return true;
    }
}