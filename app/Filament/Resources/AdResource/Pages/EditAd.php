<?php

namespace App\Filament\Resources\AdResource\Pages;

use App\Filament\Resources\AdResource;
use App\Filament\Resources\Records\BaseEditRecord;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAd extends BaseEditRecord
{
    protected static string $resource = AdResource::class;
}
