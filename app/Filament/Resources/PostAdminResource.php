<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\PostAdmin;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostAdminResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostAdminResource\RelationManagers;

class PostAdminResource extends Resource
{
    protected static ?string $model = PostAdmin::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Admin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('post_id')
                ->relationship('post', 'name')
                ->searchable()
                ->preload()
                ->required(),

                Forms\Components\Select::make('user_id')
                ->label('Admin')
                ->options(function() {
                    return User::role('admin')->pluck('name', 'id');
                })
                ->preload()
                ->required(),

                Forms\Components\TextArea::make('about')
                ->required(),

                Forms\Components\Select::make('is_active')
                ->options([
                    true => 'Active',
                    false => 'Banned'
                ])
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\ImageColumn::make('admin.photo')->circular(),
                Tables\Columns\TextColumn::make('admin.name')->sortable()->searchable(),
                Tables\Columns\ImageColumn::make('post.thumbnail'),
                Tables\Columns\TextColumn::make('post.name')->sortable()->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostAdmins::route('/'),
            'create' => Pages\CreatePostAdmin::route('/create'),
            'edit' => Pages\EditPostAdmin::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
