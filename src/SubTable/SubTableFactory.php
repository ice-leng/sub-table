<?php

declare(strict_types=1);

namespace Lengbin\SubDatabase\SubTable;

use Lengbin\SubDatabase\Enums\SubTableMode;
use Lengbin\SubDatabase\SubTable\Mode\SubTableDate;
use Lengbin\SubDatabase\SubTable\Mode\SubTableHash;

class SubTableFactory
{
    public const MAP = [
        SubTableMode::DATE => SubTableDate::class,
        SubTableMode::HASH => SubTableHash::class,
    ];

    public function make(SubTableMode $mode): AbstractSubTable
    {
        $class = self::MAP[$mode->getValue()];
        return new $class;
    }
}