<?php

namespace App\Filament\Resources\AdTemplateResource\Pages;

use App\Filament\Resources\AdTemplateResource;
use App\Filament\Resources\Records\BaseCreateRecord;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdTemplate extends BaseCreateRecord
{
    protected static string $resource = AdTemplateResource::class;
}
