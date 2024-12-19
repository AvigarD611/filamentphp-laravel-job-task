<?php

namespace App\Filament\Resources\Records;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class BaseEditRecord extends EditRecord
{
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function authorizeAccess(): void
    {
        $model = new class extends Model {};

        abort_unless(call_user_func(self::getResource() . '::canViewAny'), 403);
        abort_unless(call_user_func(self::getResource() . '::canEdit', $model), 403);
    }
}
