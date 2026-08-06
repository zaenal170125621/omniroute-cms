<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'cover_image',
        'cover_color',
        'description',
        'link',
        'tech_stack',
        'year',
        'sort_order',
        'is_active',
        'client_name',
        'duration',
        'challenge',
        'solution',
        'result',
        'metrics',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'metrics' => 'array',
        'is_active' => 'boolean',
    ];

    public const CATEGORIES = [
        'company-profile' => 'Company Profile',
        'e-commerce' => 'E-Commerce',
        'landing-page' => 'Landing Page',
        'web-app' => 'Web Application',
    ];

    public function categoryLabel(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }
}
