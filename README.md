# sub-table
简单分表

Install
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require lengbin/sub-table
```

or add

```
"lengbin/sub-table": "*"
```
to the require section of your `composer.json` file.

Use date
```php

$tableName = "t_user_log";
$pdo = new PDO();
$subTable = (new SubTableFactory)->make(SubTableMode::DATE())
$subTable->setKey(date('Y'));
// $this->subTable->suffix(); // 根据生成后缀
$this->subTable->setPdo($pdo); // 设置 pdo
$this->subTable->createSubTable($tableName); // 生成分表

```

Use hash
```php
$tableName = "t_user_log";
$pdo = new PDO();
$subTable = (new SubTableFactory)->make(SubTableMode::HASH())
$subTable->setKey(1234);
$subTable->setSlices("32"); // 设置 分片 默认 10
// $this->subTable->suffix(); // 根据hash 求余 生成后缀
$this->subTable->setPdo($pdo); // 设置 pdo
$this->subTable->createSubTable($tableName); // 生成分表

```