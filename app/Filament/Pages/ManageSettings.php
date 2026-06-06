<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Cài đặt website';

    protected static ?string $title = 'Cài đặt website';

    protected static ?string $navigationGroup = 'Hệ thống';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    /** Giá trị mặc định khi chưa cấu hình. */
    protected array $defaults = [
        'footer_about' => 'Thiết kế & thi công nội thất toàn diện theo phong cách tối giản sang trọng — kiến tạo không gian sống tinh tế, bền vững theo thời gian.',
        'footer_slogan' => 'Nội Thất Cao Cấp | Tối Giản & Sang Trọng',
        'footer_copyright' => '© {year} {brand}. All rights reserved.',
        'cta_eyebrow' => 'Bắt đầu hành trình',
        'cta_title' => 'Tìm món nội thất hoàn hảo cho ngôi nhà của bạn',
        'cta_subtitle' => 'Để chuyên viên của chúng tôi tư vấn chọn sản phẩm, phối màu và kích thước phù hợp — giúp bạn sở hữu không gian sống đúng gu và đẳng cấp.',
        'cta_button' => 'Nhận tư vấn miễn phí',
        'cta_image' => '',
        'consult_title' => 'Đăng Ký Tư Vấn',
        'consult_subtitle' => 'Để lại thông tin, đội ngũ của chúng tôi sẽ liên hệ tư vấn miễn phí.',
        'consult_needs' => "Mua sản phẩm có sẵn\nĐặt làm theo yêu cầu\nTư vấn thiết kế\nKhác",
        'contact_address' => 'Vũ Tông Phan, Thanh Xuân, Hà Nội',
        'contact_hotline' => '0900 000 000',
        'contact_email' => 'hello@studio.vn',
        'social_facebook' => '',
        'social_youtube' => '',
        'social_tiktok' => '',
        'social_zalo' => '',
    ];

    public function mount(): void
    {
        $values = [];
        foreach ($this->defaults as $key => $default) {
            $values[$key] = Setting::getValue($key, $default);
        }
        $values['site_name'] = Setting::getValue('site_name', config('app.name'));
        $this->form->fill($values);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tabs\Tab::make('Thương hiệu')->icon('heroicon-o-sparkles')->schema([
                        TextInput::make('site_name')->label('Tên thương hiệu')->required()
                            ->helperText('Hiển thị trên menu (logo chữ), footer và tiêu đề trang.'),
                    ]),

                    Tabs\Tab::make('Dải CTA')->icon('heroicon-o-megaphone')->schema([
                        TextInput::make('cta_eyebrow')->label('Nhãn nhỏ (eyebrow)'),
                        TextInput::make('cta_title')->label('Tiêu đề'),
                        Textarea::make('cta_subtitle')->label('Mô tả')->rows(2),
                        TextInput::make('cta_button')->label('Chữ trên nút'),
                        FileUpload::make('cta_image')->label('Ảnh nền')->image()->imageEditor()->directory('settings')
                            ->helperText('Để trống sẽ dùng ảnh mặc định.'),
                    ])->columns(2),

                    Tabs\Tab::make('Form tư vấn')->icon('heroicon-o-clipboard-document-list')->schema([
                        TextInput::make('consult_title')->label('Tiêu đề form'),
                        Textarea::make('consult_subtitle')->label('Mô tả ngắn')->rows(2),
                        Textarea::make('consult_needs')->label('Các lựa chọn nhu cầu')->rows(4)
                            ->helperText('Mỗi dòng là một lựa chọn trong dropdown "Nhu cầu".'),
                    ]),

                    Tabs\Tab::make('Footer')->icon('heroicon-o-bars-3-bottom-left')->schema([
                        Textarea::make('footer_about')->label('Đoạn giới thiệu')->rows(3),
                        TextInput::make('footer_slogan')->label('Slogan cuối footer'),
                        TextInput::make('footer_copyright')->label('Dòng bản quyền (copyright)')
                            ->helperText('Dùng {year} để tự điền năm hiện tại, {brand} để tự điền tên thương hiệu.'),
                    ]),

                    Tabs\Tab::make('Liên hệ')->icon('heroicon-o-phone')->schema([
                        TextInput::make('contact_address')->label('Địa chỉ'),
                        TextInput::make('contact_hotline')->label('Hotline')->tel(),
                        TextInput::make('contact_email')->label('Email')->email(),
                    ]),

                    Tabs\Tab::make('Mạng xã hội')->icon('heroicon-o-share')->schema([
                        TextInput::make('social_facebook')->label('Facebook')->url()->placeholder('https://facebook.com/...'),
                        TextInput::make('social_youtube')->label('Youtube')->url()->placeholder('https://youtube.com/...'),
                        TextInput::make('social_tiktok')->label('Tiktok')->url()->placeholder('https://tiktok.com/@...'),
                        TextInput::make('social_zalo')->label('Zalo')->url()->placeholder('https://zalo.me/...'),
                    ])->columns(2),
                ])->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Lưu thay đổi')
                ->action('save'),
        ];
    }

    public function save(): void
    {
        foreach ($this->form->getState() as $key => $value) {
            Setting::setValue($key, $value);
        }

        Notification::make()->title('Đã lưu cài đặt')->success()->send();
    }
}
