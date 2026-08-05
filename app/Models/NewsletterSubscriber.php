<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'locale',
        'confirmed',
        'confirmation_token',
        'confirmed_at',
    ];

    protected $casts = [
        'confirmed' => 'boolean',
        'confirmed_at' => 'datetime',
    ];

    public static function subscribe(string $email, string $locale = 'id'): self
    {
        $subscriber = self::firstOrCreate(
            ['email' => $email],
            [
                'locale' => $locale,
                'confirmation_token' => Str::random(64),
            ]
        );

        if (!$subscriber->confirmed) {
            $subscriber->update([
                'confirmation_token' => Str::random(64),
                'locale' => $locale,
            ]);
        }

        return $subscriber;
    }

    public function confirm(): bool
    {
        if ($this->confirmed) return true;

        $this->update([
            'confirmed' => true,
            'confirmed_at' => now(),
            'confirmation_token' => null,
        ]);

        return true;
    }

    public function scopeConfirmed($query)
    {
        return $query->where('confirmed', true);
    }
}