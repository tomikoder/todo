<?php

namespace App\Constants;

class TaskConstants
{
    public const PRIORITIES = ['low', 'medium', 'high'];
    public const STATUSES = ['to-do', 'in progress', 'done'];

    public static function formatStatuses(): string
    {
        return implode(',', self::STATUSES);
    }

    public static function formatPriorities(): string
    {
        return implode(',', self::PRIORITIES);
    }
}
