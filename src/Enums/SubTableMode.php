<?php

declare(strict_types=1);

namespace Lengbin\SubDatabase\Enums;

use Lengbin\ErrorCode\AbstractEnum;
use Lengbin\ErrorCode\Annotation\EnumMessage;

class SubTableMode extends AbstractEnum
{
    /**
     * @Message("日期")
     */
    #[EnumMessage("日期")]
    public const DATE = 'date';

    /**
     * @Message("hash")
     */
    #[EnumMessage("hash")]
    public const HASH = 'hash';
}