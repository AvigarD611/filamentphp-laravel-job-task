<?php

namespace App\Filament\Resources\AdTemplateResource\Pages;

use App\Filament\Resources\AdTemplateResource;
use App\Filament\Resources\Records\BaseListRecords;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdTemplates extends BaseListRecords
{
    protected static string $resource = AdTemplateResource::class;
}
