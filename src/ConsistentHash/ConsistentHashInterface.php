<?php

declare(strict_types=1);

namespace Lengbin\SubDatabase\ConsistentHash;

interface ConsistentHashInterface
{
    //将字符串转为hash值
    public function hash(string $str): string;

    //添加一台服务器到服务器列表中
    public function addServer(string $server): bool;

    //从服务器删除一台服务器
    public function removeServer(string $server): bool;

    //在当前的服务器列表中找到合适的服务器存放数据
    public function lookup(string $key);
}