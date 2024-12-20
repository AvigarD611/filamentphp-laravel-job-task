<?php

namespace App\Filament\Resources\AdResource\Pages;

use App\Filament\Resources\AdResource;
use App\Filament\Resources\Records\BaseCreateRecord;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAd extends BaseCreateRecord
{
    protected static string $resource = AdResource::class;
}
