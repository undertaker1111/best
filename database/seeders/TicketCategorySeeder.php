<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketCategory;

class TicketCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Hardware', 'description' => 'Hardware-related issues.'],
            ['name' => 'Software', 'description' => 'Software-related issues.'],
            ['name' => 'Network', 'description' => 'Network-related issues.'],
            ['name' => 'Other', 'description' => 'Other issues.'],
        ];
        foreach ($categories as $category) {
            TicketCategory::firstOrCreate(['name' => $category['name']], $category);
        }
    }
} 