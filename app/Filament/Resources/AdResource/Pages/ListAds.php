<?php

namespace App\Filament\Resources\AdResource\Pages;

use App\Filament\Resources\AdResource;
use App\Filament\Resources\Records\BaseListRecords;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAds extends BaseListRecords
{
    protected static string $resource = AdResource::class;
}
