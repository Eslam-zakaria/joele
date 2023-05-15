<?php

namespace Modules\Category\Seeds;


use App\Enums\CategoriesRelationEnum;
use Illuminate\Database\Seeder;
use Modules\Category\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
                [
                    'ar' => [
                        'name' => 'الأسنان',
                        'slug' => 'الأسنان',
                        'alt_image' => 'الأسنان',
                        'meta_title' => 'الأسنان',
                        'meta_description' => 'الأسنان',
                        'meta_keywords' => 'الأسنان',
                    ],
                    'en' => [
                        'name' => 'dental',
                        'slug' => 'dental',
                        'alt_image' => 'dental',
                        'meta_title' => 'dental',
                        'meta_description' => 'dental',
                        'meta_keywords' => 'dental',
                    ],
                    'image' => 'service-01.jpg',
                    'display_in' => CategoriesRelationEnum::Models
                ],
                [
                    'ar' => [
                        'name' => 'جلدية',
                        'slug' => 'جلدية',
                        'alt_image' => 'جلدية',
                        'meta_title' => 'جلدية',
                        'meta_description' => 'جلدية',
                        'meta_keywords' => 'جلدية',
                    ],
                    'en' => [
                        'name' => 'dermal',
                        'slug' => 'dermal',
                        'alt_image' => 'dermal',
                        'meta_title' => 'dermal',
                        'meta_description' => 'dermal',
                        'meta_keywords' => 'dermal',
                    ],
                    'image' => 'service-02.jpg',
                    'display_in' => CategoriesRelationEnum::Models
                ],
                [
                    'ar' => [
                        'name' => 'طبي',
                        'slug' => 'طبي',
                        'alt_image' => 'طبي',
                        'meta_title' => 'طبي',
                        'meta_description' => 'طبي',
                        'meta_keywords' => 'طبي',
                    ],
                    'en' => [
                        'name' => 'medical',
                        'slug' => 'medical',
                        'alt_image' => 'medical',
                        'meta_title' => 'medical',
                        'meta_description' => 'medical',
                        'meta_keywords' => 'medical',
                    ],
                    'image' => 'service-03.jpg',
                    'display_in' => CategoriesRelationEnum::Models
                ],
            ];

        foreach ($categories as $category){
            $data = $category;

            unset($data['image']);

            $categoryModel = Category::create($data);

            $categoryModel->addMediaFromUrl(public_path("frontend/images/services/" . $category['image']), 'category_image');
        }
    }
}
