<?php

namespace App\Filament\Resources\Records;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class BaseListRecords extends ListRecords
{
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function authorizeAccess(): void
    {
        abort_unless(call_user_func(self::getResource() . '::canViewAny'), 403);
    }
}
