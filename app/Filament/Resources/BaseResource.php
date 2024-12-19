<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    protected static function getResourceName(): string
    {
        return strtolower(str_replace('Resource', '', class_basename(static::class)));
    }
}
