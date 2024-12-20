<?php

namespace App\Filament\Resources\AdTemplatesRelationManagerResource\RelationManagers;

use App\Library\Enums\AdTemplateStatuses;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AdTemplatesRelationManager extends RelationManager
{
    protected static string $relationship = 'adTemplates';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->options(AdTemplateStatuses::getReadablePairs())
                    ->default(AdTemplateStatuses::DRAFT)
                    ->required(),

                Forms\Components\TextInput::make('canva_url')
                    ->label('Canva URL')
                    ->url()
                    ->required()
                    ->maxLength(2048),
            ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
