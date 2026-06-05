<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers\ImagesRelationManager;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Dự án';

    protected static ?string $navigationLabel = 'Dự án';

    protected static ?string $modelLabel = 'dự án';

    protected static ?string $pluralModelLabel = 'Dự án';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Thông tin dự án')
                        ->schema([
                            Forms\Components\TextInput::make('title')
                                ->label('Tên dự án')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                            Forms\Components\TextInput::make('slug')
                                ->label('Đường dẫn (slug)')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->helperText('Tự sinh từ tên dự án, có thể chỉnh.'),

                            Forms\Components\Select::make('project_category_id')
                                ->label('Danh mục')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    Forms\Components\TextInput::make('name')->label('Tên danh mục')->required(),
                                ]),

                            Forms\Components\Grid::make(3)->schema([
                                Forms\Components\TextInput::make('location')->label('Vị trí')->placeholder('Hà Nội'),
                                Forms\Components\TextInput::make('area')->label('Diện tích')->placeholder('120m²'),
                                Forms\Components\TextInput::make('year_completed')->label('Năm hoàn thành')->numeric()->minValue(1990)->maxValue(2100),
                            ]),

                            Forms\Components\Grid::make(2)->schema([
                                Forms\Components\TextInput::make('client_name')->label('Chủ đầu tư'),
                                Forms\Components\TextInput::make('style')->label('Phong cách')->placeholder('Tối giản sang trọng'),
                            ]),

                            Forms\Components\Textarea::make('summary')
                                ->label('Mô tả ngắn')
                                ->rows(3)
                                ->maxLength(500)
                                ->helperText('Hiển thị trên lưới dự án ngoài trang chủ.'),

                            Forms\Components\RichEditor::make('description')
                                ->label('Nội dung chi tiết')
                                ->columnSpanFull(),
                        ]),

                    Forms\Components\Section::make('SEO')
                        ->collapsed()
                        ->schema([
                            Forms\Components\TextInput::make('meta_title')->label('Meta title')->maxLength(255),
                            Forms\Components\Textarea::make('meta_description')->label('Meta description')->rows(2)->maxLength(500),
                        ]),
                ])
                ->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Section::make('Hình ảnh')
                        ->schema([
                            Forms\Components\FileUpload::make('cover_image')
                                ->label('Ảnh đại diện (khổ lớn)')
                                ->image()
                                ->imageEditor()
                                ->directory('projects/covers')
                                ->required()
                                ->helperText('Ảnh hero của trang chi tiết & lưới trang chủ.'),

                            Forms\Components\FileUpload::make('thumbnail')
                                ->label('Thumbnail (tối ưu lưới)')
                                ->image()
                                ->imageEditor()
                                ->directory('projects/thumbnails')
                                ->helperText('Tuỳ chọn — ảnh nhẹ để lưới tải nhanh.'),
                        ]),

                    Forms\Components\Section::make('Hiển thị')
                        ->schema([
                            Forms\Components\Toggle::make('is_published')->label('Xuất bản')->default(true),
                            Forms\Components\Toggle::make('is_featured')->label('Nổi bật trang chủ'),
                            Forms\Components\TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
                        ]),
                ])
                ->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Ảnh')
                    ->square()
                    ->height(56),

                Tables\Columns\TextColumn::make('title')
                    ->label('Tên dự án')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Project $record) => $record->location),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->badge()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Nổi bật')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Xuất bản')
                    ->boolean(),

                Tables\Columns\TextColumn::make('images_count')
                    ->label('Số ảnh')
                    ->counts('images')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tạo lúc')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_category_id')
                    ->label('Danh mục')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Nổi bật'),
                Tables\Filters\TernaryFilter::make('is_published')->label('Xuất bản'),
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

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
