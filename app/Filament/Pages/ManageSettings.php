<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
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
        $this->form->fill($values);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Giới thiệu (footer)')
                    ->description('Đoạn mô tả ngắn hiển thị dưới tên thương hiệu ở footer.')
                    ->schema([
                        Textarea::make('footer_about')->label('Đoạn giới thiệu')->rows(3),
                    ]),

                Section::make('Thông tin liên hệ')
                    ->description('Hiển thị ở footer và phần liên hệ của website.')
                    ->schema([
                        TextInput::make('contact_address')->label('Địa chỉ'),
                        TextInput::make('contact_hotline')->label('Hotline')->tel(),
                        TextInput::make('contact_email')->label('Email')->email(),
                    ])->columns(1),

                Section::make('Mạng xã hội & Kết nối')
                    ->description('Dán link trang của bạn. Để trống nếu không dùng.')
                    ->schema([
                        TextInput::make('social_facebook')->label('Facebook')->url()->placeholder('https://facebook.com/...'),
                        TextInput::make('social_youtube')->label('Youtube')->url()->placeholder('https://youtube.com/...'),
                        TextInput::make('social_tiktok')->label('Tiktok')->url()->placeholder('https://tiktok.com/@...'),
                        TextInput::make('social_zalo')->label('Zalo')->url()->placeholder('https://zalo.me/...'),
                    ])->columns(2),
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
