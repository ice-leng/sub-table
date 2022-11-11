<?php

declare(strict_types=1);

namespace Lengbin\SubDatabase\ConsistentHash;

class ConsistentHash implements ConsistentHashInterface
{
    //服务器列列表
    protected array $serverList = [];
    //虚拟节点的位置
    protected array $virtualPos = [];
    //每个节点对应5个虚节点
    protected int $virtualPosNum = 5;

    /**
     * 将字符串转换成32位无符号整数hash值
     * @param string $str
     * @return string
     */
    public function hash(string $str): string
    {
        $str = md5($str);
        return sprintf('%u', crc32($str));
    }

    /**
     * 在当前的服务器列表中找到合适的服务器存放数据
     * @param string $key 键名
     * @return string 返回服务器IP地址
     */
    public function lookup(string $key): string
    {
        $point = $this->hash($key);//落点的hash值
        $finalServer = current($this->virtualPos);//先取圆环上最小的一个节点当成结果
        foreach ($this->virtualPos as $pos => $server) {
            if ($point <= $pos) {
                $finalServer = $server;
                break;
            }
        }
        reset($this->virtualPos); //重置圆环的指针为第一个
        return $finalServer;
    }

    /**
     * 添加一台服务器到服务器列表中
     * @param string $server 服务器IP地址
     * @return bool
     */
    public function addServer(string $server): bool
    {
        if (!isset($this->serverList[$server])) {
            for ($i = 0; $i < $this->virtualPosNum; $i++) {
                $pos = $this->hash($server . '-' . $i);
                $this->virtualPos[$pos] = $server;
                $this->serverList[$server][] = $pos;
            }
            ksort($this->virtualPos, SORT_NUMERIC);
        }
        return true;
    }

    /**
     * 移除一台服务器（循环所有的虚节点，删除值为该服务器地址的虚节点）
     * @param string $server
     * @return bool
     */
    public function removeServer(string $server): bool
    {
        if (isset($this->serverList[$server])) {
            //删除对应虚节点
            foreach ($this->serverList[$server] as $pos) {
                unset($this->virtualPos[$pos]);
            }
            //删除对应服务器
            unset($this->serverList[$server]);
        }
        return true;
    }
}