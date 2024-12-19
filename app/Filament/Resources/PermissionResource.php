<?php

namespace App\Filament\Resources;

use Althinect\FilamentSpatieRolesPermissions\Resources\PermissionResource as SpatiePermissionResource;
use App\Filament\Resources\PermissionResource\Pages;
use App\Library\Enums\Permissions;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class PermissionResource extends SpatiePermissionResource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return parent::form($form);
    }

    public static function table(Table $table): Table
    {
        $table = parent::table($table);
        $table->actions([
            Tables\Actions\ViewAction::make()
                ->authorize(fn() => Filament::auth()->user()?->can(Permissions::VIEW_PERMISSION)),
            Tables\Actions\EditAction::make()
                ->authorize(fn() => Filament::auth()->user()?->can(Permissions::EDIT_PERMISSION)),
        ]);

        return $table;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit' => Pages\EditPermission::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can(Permissions::VIEW_PERMISSION);
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can(Permissions::EDIT_PERMISSION);
    }
}
