<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComponentCategory;

class ComponentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ComponentCategory::updateOrCreate(
            ['slug' => 'beads'],
            [
                'name' => 'Beads',
                'sort_order' => 1
            ]
        );

        ComponentCategory::updateOrCreate(
            ['slug' => 'charms'],
            [
                'name' => 'Charms',
                'sort_order' => 2
            ]
        );
    }
}