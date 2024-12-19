<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

abstract class BaseResource extends Resource
{
    public static function canViewAny(): bool
    {
        return auth()->user()?->can('view-' . static::getResourceName());
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('edit-' . static::getResourceName());
    }

    protected static function getResourceName(): string
    {
        // Strip 'Resource' from the class name and convert to snake_case
        return strtolower(str_replace('Resource', '', class_basename(static::class)));
    }
}