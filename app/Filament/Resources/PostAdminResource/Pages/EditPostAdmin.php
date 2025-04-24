<?php

namespace App\Filament\Resources\PostAdminResource\Pages;

use App\Filament\Resources\PostAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostAdmin extends EditRecord
{
    protected static string $resource = PostAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
