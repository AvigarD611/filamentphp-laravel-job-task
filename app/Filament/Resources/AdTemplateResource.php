<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdTemplateResource\Pages;
use App\Library\Enums\AdTemplateStatuses;
use App\Library\Enums\Permissions;
use App\Models\AdTemplate;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdTemplateResource extends Resource
{
    protected static ?string $model = AdTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                Textarea::make('description')->nullable(),
                Select::make('status')
                    ->options(AdTemplateStatuses::getReadablePairs())->default(AdTemplateStatuses::DRAFT)->required(),
                TextInput::make('canva_url')
                    ->label('Canva URL')
                    ->required()
                    ->url()
                    ->placeholder('https://www.canva.com/...')
//                    ->maxLength(2048)
                    ->helperText('Provide a valid Canva URL, starting with "https://"'),
                Select::make('ad_id')
                    ->relationship('ad', 'title')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('ad.title')->label('Ad Title')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([])
            ->actions([
                ViewAction::make()
                    ->authorize(fn() => Filament::auth()->user()?->can(Permissions::VIEW_AD_TEMPLATE)),
                EditAction::make()
                    ->authorize(fn () => Filament::auth()->user()?->can(Permissions::EDIT_AD_TEMPLATE)),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdTemplates::route('/'),
            'create' => Pages\CreateAdTemplate::route('/create'),
            'edit' => Pages\EditAdTemplate::route('/{record}/edit'),
        ];
    }
}
