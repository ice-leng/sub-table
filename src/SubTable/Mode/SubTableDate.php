<?php

declare(strict_types=1);

namespace Lengbin\SubDatabase\SubTable\Mode;

use Lengbin\SubDatabase\SubTable\AbstractSubTable;

class SubTableDate extends AbstractSubTable
{
    public function suffix(): string
    {
        return $this->getKey();
    }
}