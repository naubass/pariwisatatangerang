<?php

namespace App\Filament\Resources\PostAdminResource\Pages;

use App\Filament\Resources\PostAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostAdmins extends ListRecords
{
    protected static string $resource = PostAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
