<?php

namespace Modules\Slider\Seeds;

use Illuminate\Database\Seeder;
use Modules\Slider\Models\Slider;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sliders =
            [
                [
                    'ar' => [
                        'first_title' => 'مركز جويل الطبي الخاص',
                        'second_title' => 'نقدم الخدمات الطبية بجودة عالية من خلال الكوادر المؤهلة والتكنولوجيا المتقدمة',
                        'description' => '                                        هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.',
                    ],
                    'en' => [
                        'first_title' => 'Joele Special Medical Center',
                        'second_title' => 'We provide high quality medical services through qualified cadres and advanced technology',
                        'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit odit eius temporibus porro ducimus hic ipsam, consequuntur fuga nam neque.',
                    ],
                    'image' => 'frontend/images/slider/slider-01.jpg'
                ],
                [
                    'ar' => [
                        'first_title' => 'مركز جويل الطبي الخاص',
                        'second_title' => 'نقدم الخدمات الطبية بجودة عالية من خلال الكوادر المؤهلة والتكنولوجيا المتقدمة',
                        'description' => '                                        هناك حقيقة مثبتة منذ زمن طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل الخارجي للنص أو شكل توضع الفقرات في الصفحة التي يقرأها.',
                    ],
                    'en' => [
                        'first_title' => 'Joele Special Medical Center',
                        'second_title' => 'We provide high quality medical services through qualified cadres and advanced technology',
                        'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit odit eius temporibus porro ducimus hic ipsam, consequuntur fuga nam neque.',
                    ],
                    'image' => 'frontend/images/slider/slider-02.jpg'
                ]
            ];

        foreach ($sliders as $slider) {

            $data = $slider;

            unset($data['image']);

            $sliderModel = Slider::create($data);

            $sliderModel->addMediaFromUrl(public_path($slider['image']), 'slider_image');
        }
    }
}
