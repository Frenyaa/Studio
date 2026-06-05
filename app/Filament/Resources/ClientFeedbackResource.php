<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientFeedbackResource\Pages;
use App\Models\ClientFeedback;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientFeedbackResource extends Resource
{
    protected static ?string $model = ClientFeedback::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Khách hàng';

    protected static ?string $navigationLabel = 'Feedback khách hàng';

    protected static ?string $modelLabel = 'feedback';

    protected static ?string $pluralModelLabel = 'Feedback khách hàng';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('client_name')->label('Tên khách hàng')->required()->placeholder('Anh Kiên'),
                Forms\Components\TextInput::make('client_location')->label('Khu vực')->placeholder('Hà Nội'),
            ]),

            Forms\Components\TextInput::make('client_title')->label('Chức danh / Dự án')->placeholder('Chủ căn hộ Metropolis'),

            Forms\Components\FileUpload::make('avatar')->label('Ảnh đại diện')->image()->avatar()->directory('feedback'),

            Forms\Components\Textarea::make('content')->label('Nội dung đánh giá')->required()->rows(4),

            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Select::make('rating')->label('Đánh giá sao')->options([5 => '5 sao', 4 => '4 sao', 3 => '3 sao'])->default(5),
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
                Tables\Columns\ImageColumn::make('avatar')->label('Ảnh')->circular(),
                Tables\Columns\TextColumn::make('client_name')->label('Khách hàng')->searchable()->description(fn (ClientFeedback $r) => $r->client_location),
                Tables\Columns\TextColumn::make('content')->label('Nội dung')->limit(70)->wrap(),
                Tables\Columns\TextColumn::make('rating')->label('Sao')->badge()->color('warning'),
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
            'index' => Pages\ListClientFeedback::route('/'),
            'create' => Pages\CreateClientFeedback::route('/create'),
            'edit' => Pages\EditClientFeedback::route('/{record}/edit'),
        ];
    }
}
