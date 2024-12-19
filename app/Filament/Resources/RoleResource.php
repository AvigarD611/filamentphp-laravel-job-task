<?php

namespace App\Filament\Resources;

use Althinect\FilamentSpatieRolesPermissions\Resources\RoleResource as SpatieRoleResource;
use App\Filament\Resources\RoleResource\Pages;
use App\Library\Enums\Permissions;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleResource extends SpatieRoleResource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
    {
        return self::canViewAny();
    }

    public static function form(Form $form): Form
    {
        return parent::form($form);
    }

    public static function table(Table $table): Table
    {
        $table = parent::table($table);
        $table->actions([
            Tables\Actions\ViewAction::make()
                ->authorize(fn() => Filament::auth()->user()?->can(Permissions::VIEW_ROLE)),
            Tables\Actions\EditAction::make()
                ->authorize(fn() => Filament::auth()->user()?->can(Permissions::EDIT_ROLE)),
        ]);

        return $table;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can(Permissions::VIEW_ROLE);
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can(Permissions::EDIT_ROLE);
    }
}
