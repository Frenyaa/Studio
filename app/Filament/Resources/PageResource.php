<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Nội dung';

    protected static ?string $navigationLabel = 'Chính sách';

    protected static ?string $modelLabel = 'chính sách';

    protected static ?string $pluralModelLabel = 'Chính sách';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Nội dung trang')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Tiêu đề')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true)
                    ->helperText('Địa chỉ trang: /trang/{slug}'),

                Forms\Components\RichEditor::make('content')->label('Nội dung')->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Hiển thị & SEO')->schema([
                Forms\Components\Toggle::make('is_published')->label('Xuất bản')->default(true),
                Forms\Components\Toggle::make('show_in_footer')->label('Hiện ở footer')->default(true),
                Forms\Components\TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
                Forms\Components\TextInput::make('meta_title')->label('Meta title'),
                Forms\Components\Textarea::make('meta_description')->label('Meta description')->rows(2)->columnSpanFull(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Tiêu đề')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->color('gray'),
                Tables\Columns\IconColumn::make('show_in_footer')->label('Footer')->boolean(),
                Tables\Columns\IconColumn::make('is_published')->label('Xuất bản')->boolean(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
