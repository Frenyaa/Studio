<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Nội dung';

    protected static ?string $navigationLabel = 'Dịch vụ';

    protected static ?string $modelLabel = 'dịch vụ';

    protected static ?string $pluralModelLabel = 'Dịch vụ';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Tên dịch vụ')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

            Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),

            Forms\Components\TextInput::make('icon')
                ->label('Icon (Heroicon)')
                ->placeholder('heroicon-o-pencil-square')
                ->helperText('Tên heroicon, ví dụ: heroicon-o-home.'),

            Forms\Components\Textarea::make('summary')->label('Mô tả ngắn')->rows(2),

            Forms\Components\RichEditor::make('description')->label('Nội dung chi tiết')->columnSpanFull(),

            Forms\Components\FileUpload::make('image')->label('Ảnh minh hoạ')->image()->directory('services'),

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
                Tables\Columns\TextColumn::make('title')->label('Tên dịch vụ')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('summary')->label('Mô tả')->limit(60),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
