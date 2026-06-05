<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\ImagesRelationManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Sản phẩm';

    protected static ?string $navigationLabel = 'Sản phẩm';

    protected static ?string $modelLabel = 'sản phẩm';

    protected static ?string $pluralModelLabel = 'Sản phẩm';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Thông tin sản phẩm')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Tên sản phẩm')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                    Forms\Components\TextInput::make('slug')->label('Đường dẫn (slug)')->required()->unique(ignoreRecord: true),

                    Forms\Components\Select::make('product_category_id')
                        ->label('Loại sản phẩm')
                        ->relationship('category', 'name')
                        ->searchable()->preload()
                        ->createOptionForm([
                            Forms\Components\TextInput::make('name')->label('Tên loại')->required(),
                        ]),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('sku')->label('Mã SP (SKU)')->placeholder('V1.0'),
                        Forms\Components\TextInput::make('dimensions')->label('Kích thước')->placeholder('D2800 x R1600 (mm)'),
                    ]),

                    Forms\Components\Textarea::make('material')->label('Chất liệu')->rows(2)
                        ->placeholder('Khung gỗ dầu chống cong vênh; nệm mousse D40 dày 15cm...'),

                    Forms\Components\Textarea::make('colors')->label('Màu sắc / Tuỳ chọn')->rows(2)
                        ->placeholder('Hơn 200 màu vải, da: Bố, Nhung, Nỉ, Da công nghiệp...'),

                    Forms\Components\Textarea::make('summary')->label('Mô tả ngắn')->rows(3)->maxLength(500)
                        ->helperText('Hiển thị trên lưới sản phẩm.'),

                    Forms\Components\RichEditor::make('description')->label('Nội dung chi tiết')->columnSpanFull(),
                ]),

                Forms\Components\Section::make('SEO')->collapsed()->schema([
                    Forms\Components\TextInput::make('meta_title')->label('Meta title'),
                    Forms\Components\Textarea::make('meta_description')->label('Meta description')->rows(2),
                ]),
            ])->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Hình ảnh')->schema([
                    Forms\Components\FileUpload::make('cover_image')->label('Ảnh đại diện')->image()->imageEditor()->directory('products/covers')->required(),
                    Forms\Components\FileUpload::make('thumbnail')->label('Thumbnail (tối ưu lưới)')->image()->imageEditor()->directory('products/thumbnails'),
                ]),
                Forms\Components\Section::make('Hiển thị')->schema([
                    Forms\Components\Toggle::make('is_published')->label('Xuất bản')->default(true),
                    Forms\Components\Toggle::make('is_featured')->label('Nổi bật trang chủ'),
                    Forms\Components\TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
                ]),
            ])->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('Ảnh')->square()->height(56),
                Tables\Columns\TextColumn::make('name')->label('Tên sản phẩm')->searchable()->sortable()
                    ->description(fn (Product $record) => $record->sku ? 'SKU: ' . $record->sku : null),
                Tables\Columns\TextColumn::make('category.name')->label('Loại')->badge()->sortable(),
                Tables\Columns\IconColumn::make('is_featured')->label('Nổi bật')->boolean(),
                Tables\Columns\IconColumn::make('is_published')->label('Xuất bản')->boolean(),
                Tables\Columns\TextColumn::make('images_count')->label('Số ảnh')->counts('images')->badge()->color('gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product_category_id')->label('Loại')->relationship('category', 'name'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
