<?php

namespace App\Library\Enums;

enum AdStatuses
{
    public const PENDING = 'pending';
    public const IN_PROGRESS = 'in-progress';
    public const COMPLETED = 'completed';

    public static function getReadablePairs()
    {
        return [
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
        ];
    }
}
