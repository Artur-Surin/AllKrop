<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'ip_address',
        'status',
    ];

    public const SUBJECTS = [
        'general' => 'Загальне питання',
        'news' => 'Запропонувати новину',
        'ads' => 'Реклама та співпраця',
        'place' => 'Додати або оновити заклад',
        'other' => 'Інше',
    ];

    public const STATUSES = [
        'new' => 'Нове',
        'in_progress' => 'В обробці',
        'resolved' => 'Опрацьовано',
    ];

    public function getSubjectLabelAttribute(): string
    {
        return self::SUBJECTS[$this->subject] ?? $this->subject;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
