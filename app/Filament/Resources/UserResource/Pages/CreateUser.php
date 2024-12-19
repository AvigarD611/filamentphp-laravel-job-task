<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\Records\BaseCreateRecord;
use App\Filament\Resources\UserResource;

class CreateUser extends BaseCreateRecord
{
    protected static string $resource = UserResource::class;
}
