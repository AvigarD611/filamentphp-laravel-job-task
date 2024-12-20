<?php

namespace App\Library\Enums;

enum AdTemplateStatuses
{
    public const DRAFT = 'draft';
    public const ACTIVE = 'active';
    public const ARCHIVED = 'archived';

    public static function getReadablePairs()
    {
        return [
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active',
            self::ARCHIVED => 'Archived',
        ];
    }
}
