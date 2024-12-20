<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
use App\Filament\Resources\AdTemplatesRelationManagerResource\RelationManagers\AdTemplatesRelationManager;
use App\Library\Enums\AdStatuses;
use App\Library\Enums\Permissions;
use App\Models\Ad;
use App\Models\AdTemplate;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                Textarea::make('description')->required(),
                TextInput::make('url')->url()->required(),
                Select::make('status')
                    ->options(AdStatuses::getReadablePairs())->default(AdStatuses::PENDING)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('url')->limit(50),
                TextColumn::make('status')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([])
            ->actions([
                Action::make('Generate Ad Template')
                    ->authorize(fn() => Filament::auth()->user()?->can(Permissions::EDIT_AD_TEMPLATE))
                    ->icon('heroicon-o-document')
                    ->action(function ($record) {
                        if ($record->status === AdStatuses::COMPLETED) {
                            Notification::make()
                                ->title('Ad Template already generated.')
                                ->warning()
                                ->send();

                            return;
                        }

                        // Create a new Ad Template
                        AdTemplate::create([
                            'title' => $record->title . ' Template',
                            'description' => $record->description,
                            'status' => 'draft',
                            'canva_url' => '',
                            'ad_id' => $record->id,
                        ]);

                        // Update the Ad status to completed
                        $record->update(['status' => AdStatuses::COMPLETED]);

                        Notification::make()
                            ->title('Ad Template generated successfully!')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->color('primary'),
                ViewAction::make()
                    ->authorize(fn() => Filament::auth()->user()?->can(Permissions::VIEW_AD)),
                EditAction::make()
                    ->authorize(fn () => Filament::auth()->user()?->can(Permissions::EDIT_AD)),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AdTemplatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }
}
