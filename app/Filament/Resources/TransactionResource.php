<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Pricing;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Transaction;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Grid;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Customers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Forms\Components\Wizard\Step::make('Ticket & Price')
                        ->schema([
                            Grid::make(2) // Menggunakan grid untuk merapikan tampilan
                                ->schema([
                                    Forms\Components\Select::make('pricing_id')
                                        ->label('Tempat Wisata')
                                        ->options(fn() => Pricing::with('post')->get()->pluck('post.name', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(fn($state, callable $set) => $set('price', Pricing::find($state)?->price))
                                        ->afterStateHydrated(fn(callable $set, callable $get) => $set('price', Pricing::find($get('pricing_id'))?->price)),
                                    
                                    Forms\Components\TextInput::make('price')
                                        ->label('Harga Tiket')
                                        ->prefix('IDR')
                                        ->readOnly()
                                        ->numeric()
                                        ->required(),
                                ]),

                            Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('total_ticket')
                                        ->label('Beli Tiket')
                                        ->numeric()
                                        ->required()
                                        ->afterStateUpdated(fn(callable $set, callable $get) => $set('grand_total', ($get('price') ?? 0) * ($get('total_ticket') ?? 1))),
                                    
                                    
                                ]),
                        ]),
                    
                    Forms\Components\Wizard\Step::make('Customer Information')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Forms\Components\Select::make('user_id')
                                        ->label('Choose Email')
                                        ->options(fn() => User::role('customer')->pluck('email', 'id'))
                                        ->searchable()
                                        ->required()
                                        ->preload()
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            $user = User::find($state);
                                            if ($user) {
                                                $set('name', $user->name);
                                                $set('email', $user->email);
                                            }
                                        })
                                        ->afterStateHydrated(function (callable $set, $state) {
                                            $user = User::find($state);
                                            if ($user) {
                                                $set('name', $user->name);
                                                $set('email', $user->email);
                                            }
                                        }),
                                    
                                    Forms\Components\TextInput::make('name')
                                        ->required()
                                        ->readOnly()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('email')
                                        ->required()
                                        ->readOnly()
                                        ->maxLength(255),
                                ]),

                            Grid::make(2)
                                ->schema([
                                    Forms\Components\DatePicker::make('started_at')
                                        ->label('Tanggal Mulai')
                                        ->live()
                                        ->afterStateUpdated(fn($state, callable $set) => $set('ended_at', \Carbon\Carbon::parse($state)->addDay(1)->format('Y-m-d')))
                                        ->required(),
                                    
                                    Forms\Components\DatePicker::make('ended_at')
                                        ->label('Tanggal Berakhir')
                                        ->readOnly(),
                                ]),
                        ]),
                    
                    Forms\Components\Wizard\Step::make('Payment Information')
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Forms\Components\TextInput::make('grand_total')
                                        ->label('Total Harga')
                                        ->prefix('IDR')
                                        ->readOnly()
                                        ->numeric()
                                        ->required(),

                                    ToggleButtons::make('is_paid')
                                        ->label('Apakah Sudah Membayar?')
                                        ->boolean()
                                        ->grouped()
                                        ->icons([
                                            true => 'heroicon-o-check-circle',
                                            false => 'heroicon-o-clock',
                                        ])
                                        ->required(),
                                    
                                    Forms\Components\Select::make('payment_type')
                                        ->options([
                                            'Midtrans' => 'Midtrans',
                                            'Manual' => 'Manual'
                                        ])
                                        ->required(),
                                ]),

                            Forms\Components\FileUpload::make('proof')
                                ->image(),
                        ]),
                ])
                ->columnSpan('full')
                ->columns(1)
                ->skippable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\ImageColumn::make('User.photo')->circular(),
                Tables\Columns\TextColumn::make('User.name')->searchable(),
                Tables\Columns\TextColumn::make('booking_trx_id')->searchable(),
                Tables\Columns\ImageColumn::make('pricings.post.thumbnail')->label('Thumbnail'),
                Tables\Columns\TextColumn::make('pricings.post.name')->label('Tempat Wisata')->searchable(),
                Tables\Columns\TextColumn::make('grand_total'),
                Tables\Columns\IconColumn::make('is_paid')
                ->boolean()
                ->trueColor('success')
                ->falseColor('danger')
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->label('Terverifikasi'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                ->label('Approve')
                ->action(function (Transaction $record) {
                    $record->is_paid = true;
                    $record->save();

                    Notification::make()
                ->title('Transaction Approved')
                ->success()
                ->body('Transaction has successfully approved')
                ->send();
                })
                ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Transaction $record) => !$record->is_paid),

                
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
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
