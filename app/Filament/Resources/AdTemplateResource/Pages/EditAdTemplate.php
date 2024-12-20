<?php

namespace App\Filament\Resources\AdTemplateResource\Pages;

use App\Filament\Resources\AdTemplateResource;
use App\Filament\Resources\Records\BaseEditRecord;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdTemplate extends BaseEditRecord
{
    protected static string $resource = AdTemplateResource::class;
}
