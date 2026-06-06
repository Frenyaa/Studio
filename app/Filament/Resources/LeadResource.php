<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Models\Lead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'Khách hàng';

    protected static ?string $navigationLabel = 'Khách đăng ký';

    protected static ?string $modelLabel = 'khách đăng ký';

    protected static ?string $pluralModelLabel = 'Khách đăng ký';

    protected static ?int $navigationSort = 0;

    /** Badge số lead mới trên menu. */
    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'new')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Thông tin khách hàng')
                ->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')->label('Họ và tên')->required(),
                        Forms\Components\TextInput::make('phone')->label('Số điện thoại')->required()->tel(),
                    ]),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('email')->label('Email')->email(),
                        Forms\Components\TextInput::make('need')->label('Nhu cầu'),
                    ]),
                    Forms\Components\Textarea::make('message')->label('Lời nhắn')->rows(3),
                ]),

            Forms\Components\Section::make('Xử lý')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Trạng thái')
                        ->options(Lead::STATUSES)
                        ->default('new')
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                            if (in_array($state, ['contacting', 'won', 'lost'])) {
                                $set('contacted_at', now());
                            }
                        }),
                    Forms\Components\DateTimePicker::make('contacted_at')->label('Thời điểm liên hệ'),
                    Forms\Components\Textarea::make('admin_note')->label('Ghi chú nội bộ')->rows(3),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Thời gian')->dateTime('d/m/Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Họ tên')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('phone')->label('SĐT')->searchable()->copyable()->icon('heroicon-m-phone'),
                Tables\Columns\TextColumn::make('need')
                    ->label('Nhu cầu')
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('message')->label('Lời nhắn')->limit(40)->tooltip(fn ($record) => $record->message),
                Tables\Columns\SelectColumn::make('status')
                    ->label('Trạng thái')
                    ->options(Lead::STATUSES)
                    ->selectablePlaceholder(false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Trạng thái')->options(Lead::STATUSES),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
