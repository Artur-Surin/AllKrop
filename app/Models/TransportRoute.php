<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRoute extends Model
{
    use HasFactory;

    protected $table = 'transport_routes';

    protected $fillable = [
        'number',
        'type',
        'route_from',
        'route_to',
        'interval',
        'stops',
    ];

    protected $casts = [
        'stops' => 'array',
    ];

    public function getFromAttribute(): string
    {
        return $this->route_from;
    }

    public function getToAttribute(): string
    {
        return $this->route_to;
    }

    public function getStopsListAttribute(): array
    {
        if (! empty($this->stops) && is_array($this->stops)) {
            return $this->stops;
        }

        return match ($this->number) {
            '1' => ['Залізничний вокзал', 'вул. Ентузіастів', 'вул. Гоголя', 'пл. Героїв Майдану', 'вул. Тараса Карпи', 'вул. Космонавта Попова'],
            '3' => ['Центр', 'вул. Велика Перспективна', 'вул. Дворцова', 'Ковалівський парк', 'Житломасив «Ковалівка»'],
            '9' => ['Аеропорт', 'вул. Мурманська', 'вул. Пацаєва', 'вул. Шевченка', 'Центральна площа'],
            '14' => ['Пацаєва', 'вул. Генерала Жадова', 'вул. Архітектора Снігурьова', 'вул. Комарова', 'Лікарня швидкої допомоги'],
            '27' => ['Гірниче', 'вул. Генерала Алмазова', 'вул. Євгена Маланюка', 'вул. Ганни Барвінок', 'Центральний ринок'],
            '150' => ['Кропивницький', 'Автовокзал', 'смт Новгородка', 'смт Бобринець', 'Знам\'янка'],
            default => [$this->route_from, 'Центральний зупиночний пункт', $this->route_to],
        };
    }
}
