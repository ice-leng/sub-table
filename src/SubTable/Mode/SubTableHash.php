<?php

declare(strict_types=1);

namespace Lengbin\SubDatabase\SubTable\Mode;

use Lengbin\SubDatabase\SubTable\AbstractSubTable;

class SubTableHash extends AbstractSubTable
{
    private int $slices = 10;

    /**
     * @return int
     */
    public function getSlices(): int
    {
        return $this->slices;
    }

    /**
     * @param int $slices
     * @return SubTableHash
     */
    public function setSlices(int $slices): SubTableHash
    {
        $this->slices = $slices;
        return $this;
    }

    public function suffix(): string
    {
        $crc = sprintf('%u', crc32(md5($this->getKey())));
        return (string)fmod((int)$crc, $this->getSlices());
    }
}