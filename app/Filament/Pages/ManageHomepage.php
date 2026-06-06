<?php

namespace App\Filament\Pages;

use App\Models\Page as PageModel;
use App\Models\Service;
use App\Models\SiteStat;
use App\Models\WorkflowStep;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageHomepage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-window';

    protected static ?string $navigationLabel = 'Nội dung trang chủ';

    protected static ?string $title = 'Nội dung trang chủ';

    protected static ?string $navigationGroup = 'Trang chủ';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.manage-homepage';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'services' => Service::orderBy('sort_order')->get()
                ->map(fn ($r) => $r->only(['id', 'title', 'summary', 'image', 'is_active']))->toArray(),
            'steps' => WorkflowStep::orderBy('sort_order')->get()
                ->map(fn ($r) => $r->only(['id', 'number', 'title', 'description', 'is_active']))->toArray(),
            'stats' => SiteStat::orderBy('sort_order')->get()
                ->map(fn ($r) => $r->only(['id', 'value', 'prefix', 'suffix', 'label', 'is_active']))->toArray(),
            'pages' => PageModel::orderBy('sort_order')->get()
                ->map(fn ($r) => $r->only(['id', 'title', 'content', 'is_published', 'show_in_footer']))->toArray(),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tabs\Tab::make('Dịch vụ')->schema([
                        Repeater::make('services')
                            ->hiddenLabel()
                            ->schema([
                                Hidden::make('id'),
                                TextInput::make('title')->label('Tên dịch vụ')->required(),
                                Textarea::make('summary')->label('Mô tả ngắn')->rows(2),
                                FileUpload::make('image')->label('Ảnh/Icon')->image()->directory('services'),
                                Toggle::make('is_active')->label('Hiển thị')->default(true),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Dịch vụ mới')
                            ->collapsible()->reorderable()->cloneable()
                            ->addActionLabel('Thêm dịch vụ')
                            ->columns(2),
                    ]),

                    Tabs\Tab::make('Quy trình')->schema([
                        Repeater::make('steps')
                            ->hiddenLabel()
                            ->schema([
                                Hidden::make('id'),
                                TextInput::make('number')->label('Số (01, 02...)'),
                                TextInput::make('title')->label('Tên bước')->required(),
                                Textarea::make('description')->label('Mô tả')->rows(2)->columnSpanFull(),
                                Toggle::make('is_active')->label('Hiển thị')->default(true),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Bước mới')
                            ->collapsible()->reorderable()
                            ->addActionLabel('Thêm bước')
                            ->columns(2),
                    ]),

                    Tabs\Tab::make('Chỉ số')->schema([
                        Repeater::make('stats')
                            ->hiddenLabel()
                            ->schema([
                                Hidden::make('id'),
                                TextInput::make('value')->label('Giá trị')->required()->placeholder('10'),
                                TextInput::make('prefix')->label('Tiền tố'),
                                TextInput::make('suffix')->label('Hậu tố')->placeholder('+'),
                                TextInput::make('label')->label('Nhãn')->required()->placeholder('Năm kinh nghiệm'),
                                Toggle::make('is_active')->label('Hiển thị')->default(true),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? 'Chỉ số mới')
                            ->collapsible()->reorderable()
                            ->addActionLabel('Thêm chỉ số')
                            ->columns(2),
                    ]),

                    Tabs\Tab::make('Chính sách')->schema([
                        Repeater::make('pages')
                            ->hiddenLabel()
                            ->schema([
                                Hidden::make('id'),
                                TextInput::make('title')->label('Tiêu đề')->required(),
                                RichEditor::make('content')->label('Nội dung')->columnSpanFull(),
                                Toggle::make('is_published')->label('Xuất bản')->default(true),
                                Toggle::make('show_in_footer')->label('Hiện ở footer')->default(true),
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? 'Trang mới')
                            ->collapsible()->collapsed()->reorderable()
                            ->addActionLabel('Thêm chính sách')
                            ->columns(2),
                    ]),
                ])->persistTabInQueryString(),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')->label('Lưu thay đổi')->action('save'),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        $this->syncRepeater(Service::class, $state['services'] ?? [], ['title', 'summary', 'image', 'is_active']);
        $this->syncRepeater(WorkflowStep::class, $state['steps'] ?? [], ['number', 'title', 'description', 'is_active']);
        $this->syncRepeater(SiteStat::class, $state['stats'] ?? [], ['value', 'prefix', 'suffix', 'label', 'is_active']);
        $this->syncRepeater(PageModel::class, $state['pages'] ?? [], ['title', 'content', 'is_published', 'show_in_footer']);

        Notification::make()->title('Đã lưu nội dung trang chủ')->success()->send();
    }

    /** Đồng bộ dữ liệu repeater với bảng: cập nhật/ tạo mới/ xoá mục bị bỏ, đặt lại thứ tự. */
    private function syncRepeater(string $model, array $items, array $fields): void
    {
        $keepIds = [];

        foreach (array_values($items) as $index => $row) {
            $data = [];
            foreach ($fields as $f) {
                $data[$f] = $row[$f] ?? null;
            }
            $data['sort_order'] = $index;

            if (! empty($row['id']) && ($record = $model::find($row['id']))) {
                $record->update($data);
            } else {
                $record = $model::create($data);
            }
            $keepIds[] = $record->id;
        }

        $model::whereNotIn('id', $keepIds ?: [0])->delete();
    }
}
