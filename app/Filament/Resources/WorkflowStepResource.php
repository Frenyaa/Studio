<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkflowStepResource\Pages;
use App\Models\WorkflowStep;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WorkflowStepResource extends Resource
{
    protected static ?string $model = WorkflowStep::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-left';

    protected static ?string $navigationGroup = 'Nội dung';

    protected static ?string $navigationLabel = 'Quy trình làm việc';

    protected static ?string $modelLabel = 'bước quy trình';

    protected static ?string $pluralModelLabel = 'Quy trình làm việc';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('number')
                ->label('Số thứ tự hiển thị')
                ->placeholder('01')
                ->helperText('Con số lớn làm điểm nhấn (01, 02, 03...).'),

            Forms\Components\TextInput::make('title')
                ->label('Tên bước')
                ->required()
                ->placeholder('Khảo sát'),

            Forms\Components\Textarea::make('description')->label('Mô tả')->rows(3),

            Forms\Components\TextInput::make('icon')->label('Icon (Heroicon)')->placeholder('heroicon-o-magnifying-glass'),

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
                Tables\Columns\TextColumn::make('number')->label('Số')->badge()->color('gray'),
                Tables\Columns\TextColumn::make('title')->label('Tên bước')->searchable(),
                Tables\Columns\TextColumn::make('description')->label('Mô tả')->limit(60),
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
            'index' => Pages\ListWorkflowSteps::route('/'),
            'create' => Pages\CreateWorkflowStep::route('/create'),
            'edit' => Pages\EditWorkflowStep::route('/{record}/edit'),
        ];
    }
}
