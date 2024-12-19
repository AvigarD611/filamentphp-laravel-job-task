<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\Records\BaseListRecords;
use App\Filament\Resources\UserResource;

class ListUsers extends BaseListRecords
{
    protected static string $resource = UserResource::class;
}
