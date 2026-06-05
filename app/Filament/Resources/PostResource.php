<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Nội dung';

    protected static ?string $navigationLabel = 'Bài viết (Cảm hứng)';

    protected static ?string $modelLabel = 'bài viết';

    protected static ?string $pluralModelLabel = 'Bài viết';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Nội dung bài viết')->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Tiêu đề')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                    Forms\Components\TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),

                    Forms\Components\Textarea::make('excerpt')->label('Mô tả ngắn')->rows(3)->maxLength(500)
                        ->helperText('Hiển thị trên lưới bài viết ngoài trang chủ.'),

                    Forms\Components\RichEditor::make('content')->label('Nội dung chi tiết')->columnSpanFull(),
                ]),

                Forms\Components\Section::make('SEO')->collapsed()->schema([
                    Forms\Components\TextInput::make('meta_title')->label('Meta title'),
                    Forms\Components\Textarea::make('meta_description')->label('Meta description')->rows(2),
                ]),
            ])->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Ảnh & phân loại')->schema([
                    Forms\Components\FileUpload::make('cover_image')->label('Ảnh bìa')->image()->imageEditor()->directory('posts'),
                    Forms\Components\TextInput::make('category')->label('Chủ đề')->placeholder('Xu hướng'),
                ]),
                Forms\Components\Section::make('Xuất bản')->schema([
                    Forms\Components\Toggle::make('is_published')->label('Xuất bản')->default(true),
                    Forms\Components\DateTimePicker::make('published_at')->label('Thời gian đăng'),
                    Forms\Components\TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
                ]),
            ])->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label('Ảnh')->square()->height(56),
                Tables\Columns\TextColumn::make('title')->label('Tiêu đề')->searchable()->sortable()->wrap(),
                Tables\Columns\TextColumn::make('category')->label('Chủ đề')->badge()->color('gray'),
                Tables\Columns\IconColumn::make('is_published')->label('Xuất bản')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->label('Ngày đăng')->date('d/m/Y')->sortable(),
            ])
            ->filters([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
