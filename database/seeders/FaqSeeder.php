<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run()
    {
        foreach (Faq::DEFAULTS as $i => $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                $faq + ['sort_order' => $i + 1]
            );
        }
    }
}
