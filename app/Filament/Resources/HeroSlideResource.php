<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'Trang chủ';

    protected static ?string $navigationLabel = 'Hero / Video nền';

    protected static ?string $modelLabel = 'hero';

    protected static ?string $pluralModelLabel = 'Hero / Video nền';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Video nền')
                ->description('Tải lên file video MP4 hoặc dán link CDN/YouTube. Ưu tiên file upload nếu có.')
                ->schema([
                    Forms\Components\FileUpload::make('video_file')
                        ->label('File video (MP4)')
                        ->directory('hero/videos')
                        ->acceptedFileTypes(['video/mp4', 'video/webm'])
                        ->maxSize(51200) // 50MB
                        ->helperText('Khuyến nghị nén dưới 10MB, độ phân giải 1920x1080.'),

                    Forms\Components\TextInput::make('video_url')
                        ->label('Hoặc link video (YouTube / Vimeo / MP4)')
                        ->url()
                        ->placeholder('https://youtu.be/... hoặc https://cdn.example.com/hero.mp4')
                        ->helperText('Dán link để khỏi upload video nặng. Hỗ trợ YouTube, Vimeo hoặc link MP4 trực tiếp. (Nếu đã upload file thì file được ưu tiên.)'),

                    Forms\Components\FileUpload::make('poster_image')
                        ->label('Ảnh poster (upload)')
                        ->image()
                        ->directory('hero/posters')
                        ->helperText('Hiển thị trong lúc video chưa tải xong (hoặc khi không có video).'),

                    Forms\Components\TextInput::make('poster_url')
                        ->label('Hoặc link ảnh poster')
                        ->url()
                        ->placeholder('https://...')
                        ->helperText('Dán link ảnh để khỏi upload. Có link thì link được ưu tiên.'),
                ])->columns(1),

            Forms\Components\Section::make('Nội dung overlay')
                ->schema([
                    Forms\Components\TextInput::make('slogan')
                        ->label('Slogan lớn')
                        ->required()
                        ->default('THIẾT KẾ THI CÔNG TOÀN DIỆN CHO NGÔI NHÀ CỦA BẠN'),

                    Forms\Components\TextInput::make('sub_slogan')->label('Slogan phụ'),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('cta_label')->label('Chữ trên nút CTA')->default('XEM DỰ ÁN'),
                        Forms\Components\TextInput::make('cta_anchor')->label('Liên kết neo (anchor)')->default('#portfolio')->helperText('Ví dụ: #portfolio để cuộn mượt xuống lưới dự án.'),
                    ]),

                    Forms\Components\Toggle::make('show_logo_overlay')->label('Hiện logo phóng to mờ dần khi cuộn')->default(true),
                ]),

            Forms\Components\Section::make('Hiển thị')
                ->schema([
                    Forms\Components\Toggle::make('is_active')->label('Kích hoạt')->default(true),
                    Forms\Components\TextInput::make('sort_order')->label('Thứ tự')->numeric()->default(0),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('poster_image')->label('Poster')->height(48),
                Tables\Columns\TextColumn::make('slogan')->label('Slogan')->limit(50)->wrap(),
                Tables\Columns\IconColumn::make('show_logo_overlay')->label('Logo')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Kích hoạt')->boolean(),
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
            'index' => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit' => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
