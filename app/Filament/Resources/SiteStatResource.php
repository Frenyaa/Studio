<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteStatResource\Pages;
use App\Models\SiteStat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteStatResource extends Resource
{
    protected static ?string $model = SiteStat::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Nội dung';

    protected static ?string $navigationLabel = 'Chỉ số ấn tượng';

    protected static ?string $modelLabel = 'chỉ số';

    protected static ?string $pluralModelLabel = 'Chỉ số ấn tượng';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('value')
                ->label('Giá trị')
                ->required()
                ->placeholder('10')
                ->helperText('Phần số để Counter chạy, ví dụ 10, 30, 80.'),

            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('prefix')->label('Tiền tố')->placeholder(''),
                Forms\Components\TextInput::make('suffix')->label('Hậu tố')->placeholder('+')->helperText('Ví dụ: "+", "/63".'),
            ]),

            Forms\Components\TextInput::make('label')->label('Nhãn')->required()->placeholder('Năm kinh nghiệm'),

            Forms\Components\Grid::make(2)->schema([
                Forms\Components\Toggle::make('is_active')->label('Hiển thị')->default(true),
                Forms\Components\TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->label('Giá trị')
                    ->formatStateUsing(fn ($record) => trim(($record->prefix ?? '') . $record->value . ($record->suffix ?? '')))
                    ->badge(),
                Tables\Columns\TextColumn::make('label')->label('Nhãn')->searchable(),
                Tables\Columns\IconColumn::make('is_active')->label('Hiển thị')->boolean(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteStats::route('/'),
            'create' => Pages\CreateSiteStat::route('/create'),
            'edit' => Pages\EditSiteStat::route('/{record}/edit'),
        ];
    }
}
