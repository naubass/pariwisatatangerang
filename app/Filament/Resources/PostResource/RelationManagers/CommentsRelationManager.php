<?php

namespace App\Filament\Resources\PostResource\RelationManagers;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('comment')
                    ->required()
                    ->maxLength(255),

                    Forms\Components\DateTimePicker::make('comment_at')
                        ->default(now()) // Secara otomatis mengisi waktu saat ini
                        ->required(),

                    
                
                Forms\Components\Select::make('user_id')
                    ->label('Customer')
                    ->options(User::whereHas('roles', function ($query) {
                        $query->where('name', 'customer'); 
                    })->pluck('name', 'id'))
                    ->preload()
                    ->required(),
                
                
                    
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                Tables\Columns\ImageColumn::make('User.photo')->circular(),
                Tables\Columns\TextColumn::make('User.name'),
                Tables\Columns\TextColumn::make('comment'),
                Tables\Columns\TextColumn::make('comment_at')
                    ->label('Tanggal Komentar')
                ->dateTime('d M Y H:i') // Format: 30 Mar 2025 14:30

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
