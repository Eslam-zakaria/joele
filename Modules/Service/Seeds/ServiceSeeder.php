<?php

namespace Modules\Service\Seeds;


use Illuminate\Database\Seeder;
use Modules\Service\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
                'ar' => [
                    'name' => 'اللأسنان',
                    'slug' => 'اللأسنان',
                    'description' => 'في المركز ستعيش تجربة فريدة من نوعها أثناء فترة علاجك لأننا رائدون في الرعاية الصحية بوجود بيئة مريحة ورعاية متكاملة نوفرها لك، كما إننا نهدف الى بناء جسور الثقة مع جميع عملاؤنا عن طريق التعليم والتثقيف الصحي بالإضافة الى المصداقية',
                    'content' => 'في المركز ستعيش تجربة فريدة من نوعها أثناء فترة علاجك لأننا رائدون في الرعاية الصحية بوجود بيئة مريحة ورعاية متكاملة نوفرها لك، كما إننا نهدف الى بناء جسور الثقة مع جميع عملاؤنا عن طريق التعليم والتثقيف الصحي بالإضافة الى المصداقية',
                ],
                'en' => [
                    'name' => 'Dental',
                    'slug' => 'Dental',
                    'description' => 'At Ram Clinics, you will live a unique experience during your treatment because we are pioneers in healthcare with a comfortable
                    environment and integrated care that we provide to you.',
                    'content' => 'At Ram Clinics, you will live a unique experience during your treatment because we are pioneers in healthcare with a comfortable
                    environment and integrated care that we provide to you, and we aim to build bridges of trust with all our clients through
                    education and health education in addition to credibility',
                ],
                'image' => '/frontend/images/services/service-01.jpg',
                'category_id' => 1
            ],

            [
                'ar' => [
                    'name' => 'الجلدية',
                    'slug' => 'الجلدية',
                    'description' => 'في المركز ستعيش تجربة فريدة من نوعها أثناء فترة علاجك لأننا رائدون في الرعاية الصحية بوجود بيئة مريحة ورعاية متكاملة نوفرها لك، كما إننا نهدف الى بناء جسور الثقة مع جميع عملاؤنا عن طريق التعليم والتثقيف الصحي بالإضافة الى المصداقية',
                    'content' => 'في المركز ستعيش تجربة فريدة من نوعها أثناء فترة علاجك لأننا رائدون في الرعاية الصحية بوجود بيئة مريحة ورعاية متكاملة نوفرها لك، كما إننا نهدف الى بناء جسور الثقة مع جميع عملاؤنا عن طريق التعليم والتثقيف الصحي بالإضافة الى المصداقية',
                ],
                'en' => [
                    'name' => 'Derma',
                    'slug' => 'Derma',
                    'description' => 'At Ram Clinics, you will live a unique experience during your treatment because we are pioneers in healthcare with a comfortable
                    environment and integrated care that we provide to you.',
                    'content' => 'At Ram Clinics, you will live a unique experience during your treatment because we are pioneers in healthcare with a comfortable
                    environment and integrated care that we provide to you, and we aim to build bridges of trust with all our clients through
                    education and health education in addition to credibility',
                ],
                'image' => '/frontend/images/services/service-02.jpg',
                'category_id' => 2
            ],

            [
                'ar' => [
                    'name' => 'الطبية',
                    'slug' => 'الطبية',
                    'description' => 'في المركز ستعيش تجربة فريدة من نوعها أثناء فترة علاجك لأننا رائدون في الرعاية الصحية بوجود بيئة مريحة ورعاية متكاملة نوفرها لك، كما إننا نهدف الى بناء جسور الثقة مع جميع عملاؤنا عن طريق التعليم والتثقيف الصحي بالإضافة الى المصداقية',
                    'content' => 'في المركز ستعيش تجربة فريدة من نوعها أثناء فترة علاجك لأننا رائدون في الرعاية الصحية بوجود بيئة مريحة ورعاية متكاملة نوفرها لك، كما إننا نهدف الى بناء جسور الثقة مع جميع عملاؤنا عن طريق التعليم والتثقيف الصحي بالإضافة الى المصداقية',
                ],
                'en' => [
                    'name' => 'Medical',
                    'slug' => 'Medical',
                    'description' => 'At Ram Clinics, you will live a unique experience during your treatment because we are pioneers in healthcare with a comfortable
                    environment and integrated care that we provide to you.',
                    'content' => 'At Ram Clinics, you will live a unique experience during your treatment because we are pioneers in healthcare with a comfortable
                    environment and integrated care that we provide to you, and we aim to build bridges of trust with all our clients through
                    education and health education in addition to credibility',
                ],
                'image' => '/frontend/images/services/service-03.jpg',
                'category_id' => 3
            ],
        ];

        foreach ($services as $service){
            $data = $service;

            unset($data['image']);

            $serviceModel = Service::create($data);

            $serviceModel->addMediaFromUrl(public_path($service['image']), 'service_image');
        }
    }
}
