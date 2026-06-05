<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    public const STATUSES = [
        'new' => 'Mới',
        'contacting' => 'Đang liên hệ',
        'won' => 'Đã chốt hợp đồng',
        'lost' => 'Không thành công',
    ];

    public const NEEDS = [
        'thiet-ke' => 'Thiết kế',
        'thi-cong-tron-goi' => 'Thi công trọn gói',
        'cai-tao' => 'Cải tạo',
    ];

    protected $fillable = [
        'name',
        'phone',
        'email',
        'need',
        'message',
        'status',
        'admin_note',
        'source',
        'ip_address',
        'contacted_at',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getNeedLabelAttribute(): ?string
    {
        return self::NEEDS[$this->need] ?? $this->need;
    }
}
