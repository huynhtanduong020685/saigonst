<?php

namespace Botble\RealEstate\Seeders;

use Artisan;
use Botble\RealEstate\Models\Project;
use Botble\RealEstate\Models\Property;
use Botble\RealEstate\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::truncate();

        $categories = [
            [
                'name'       => 'Apartment',
                'is_default' => true,
                'order'      => 0,
            ],
            [
                'name'       => 'Villa',
                'is_default' => false,
                'order'      => 1,
            ],
            [
                'name'       => 'Condo',
                'is_default' => false,
                'order'      => 2,
            ],
            [
                'name'       => 'House',
                'is_default' => false,
                'order'      => 3,
            ],
            [
                'name'       => 'Land',
                'is_default' => false,
                'order'      => 4,
            ],
            [
                'name'       => 'Commercial property',
                'is_default' => false,
                'order'      => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            Artisan::call('cms:language:sync', ['table' => 're_categories', 'reference' => Category::class]);
        }

        $properties = Property::get();

        foreach ($properties as $property) {
            $property->category_id = Category::inRandomOrder()->value('id');
            $property->save();
        }

        $projects = Project::get();

        foreach ($projects as $project) {
            $project->category_id = Category::inRandomOrder()->value('id');
            $project->save();
        }
    }
}
