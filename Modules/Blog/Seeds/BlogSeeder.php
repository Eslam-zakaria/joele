<?php

namespace Modules\Blog\Seeds;


use Illuminate\Database\Seeder;
use Modules\Blog\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $blogs = [
            [
                'category_id' => 1,
                'doctor_id' => 1,
                'title' => 'Information about Orthodontics',
                'slug' => 'Information-about-Orthodontics',
                'description' => 'Lorem, ipsum dolor Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam error',
                'content' => "Lorem, ipsum dolor Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam error,
                                        praesentium laboriosam repudiandae iusto quasi accusantium nihil non doloremque illum,
                                        nisi aliquam doloribus veritatis ducimus suscipit debitis dolores necessitatibus impedit.",
                'meta_title'        => 'Information about Orthodontics',
                'meta_description'  => 'Lorem, ipsum dolor Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam error,',
                'meta_keywords' => 'Information, about, Orthodontics',
                'alt_image'  => 'Information about Orthodontics',
                'locale' => 'en',
                'image' => '/frontend/images/articles/article-01.jpg'
            ],
            [
                'category_id' => 2,
                'doctor_id' => 2,
                'title' => 'معلومات حول تقويم الاسنان',
                'slug' => 'معلومات-حول-تقويم-الاسنان',
                'description' => 'تعريف تقويم الأسنان:هو أحد فروع طب الأسنان الذي يعنى بإصلاح و تعديل عيوب انتظام الأسنان',
                'content' => 'تعريف تقويم الأسنان:هو أحد فروع طب الأسنان الذي يعنى بإصلاح و تعديل عيوب انتظام الأسنان و اتساقها و معالجة عيوب الأطباق السني، و ذلك نتيجة لخلل في الأ',
                'meta_title' => '1 معلومات حول تقويم الاسنان',
                'meta_description'  => 'تعريف تقويم الأسنان:هو أحد فروع طب الأسنان الذي يعنى بإصلاح و تعديل عيوب انتظام الأسنان1',
                'meta_keywords' => 'معلومات, حول, تقويم, الاسنان',
                'alt_image'  => 'معلومات حول تقويم الاسنان',
                'locale' => 'ar',
                'image' => '/frontend/images/articles/article-02.jpg'
            ],
        ];

        foreach ($blogs as $blog){

            $data = $blog;

            unset($data['image']);

            $blogModel = Blog::create($data);

            $blogModel->addMediaFromUrl(public_path($blog['image']), 'blog_image');
        }
    }
}
