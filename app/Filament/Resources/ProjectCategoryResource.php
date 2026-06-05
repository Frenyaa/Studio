<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectCategoryResource\Pages;
use App\Models\ProjectCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectCategoryResource extends Resource
{
    protected static ?string $model = ProjectCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Dự án';

    protected static ?string $navigationLabel = 'Danh mục dự án';

    protected static ?string $modelLabel = 'danh mục';

    protected static ?string $pluralModelLabel = 'Danh mục dự án';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Tên danh mục')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

            Forms\Components\TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->unique(ignoreRecord: true),

            Forms\Components\Textarea::make('description')->label('Mô tả')->rows(3),

            Forms\Components\TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),

            Forms\Components\Toggle::make('is_active')->label('Hiển thị')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Tên')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->color('gray'),
                Tables\Columns\TextColumn::make('projects_count')->label('Số dự án')->counts('projects')->badge(),
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
            'index' => Pages\ListProjectCategories::route('/'),
            'create' => Pages\CreateProjectCategory::route('/create'),
            'edit' => Pages\EditProjectCategory::route('/{record}/edit'),
        ];
    }
}
