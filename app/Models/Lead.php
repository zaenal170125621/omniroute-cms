<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'service_id',
        'package',
        'budget',
        'timeline',
        'message',
        'status',
        'source',
        'internal_notes',
    ];

    public const STATUSES = [
        'baru' => ['label' => 'Baru', 'color' => '#2563EB'],
        'dihubungi' => ['label' => 'Dihubungi', 'color' => '#D97706'],
        'proposal' => ['label' => 'Proposal', 'color' => '#7C3AED'],
        'deal' => ['label' => 'Deal', 'color' => '#16A34A'],
        'batal' => ['label' => 'Batal', 'color' => '#9CA3AF'],
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function histories()
    {
        return $this->hasMany(LeadHistory::class)->latest();
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status]['label'] ?? ucfirst($this->status);
    }

    public function statusColor(): string
    {
        return self::STATUSES[$this->status]['color'] ?? '#6B7280';
    }

    public function sourceLabel(): string
    {
        return ucfirst(str_replace('_', ' ', $this->source ?? ''));
    }

    public function createdLabel(): string
    {
        return $this->created_at->format('d M Y H:i');
    }
}
