<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Thư viện ảnh dự án';

    protected static ?string $modelLabel = 'ảnh';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\FileUpload::make('image')
                ->label('Ảnh chi tiết')
                ->image()
                ->imageEditor()
                ->directory('projects/gallery')
                ->required()
                ->columnSpanFull(),

            Forms\Components\TextInput::make('caption')
                ->label('Chú thích')
                ->maxLength(255),

            Forms\Components\TextInput::make('sort_order')
                ->label('Thứ tự')
                ->numeric()
                ->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Ảnh')
                    ->height(64),
                Tables\Columns\TextColumn::make('caption')
                    ->label('Chú thích')
                    ->limit(40),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Thứ tự'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Thêm ảnh'),
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
