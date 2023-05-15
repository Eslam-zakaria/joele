<?php

namespace Modules\Lecture\Seeds;


use Illuminate\Database\Seeder;
use Modules\Lecture\Models\Lecture;

class LectureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lectures = [
            [
                'ar' => [
                    'title' => 'إجتماع أطباء الأسنان 1',
                ],
                'en' => [
                    'title' => '1 Dentists meeting',
                ],
                'category_id' => 1,
                'link' => asset('frontend/videos/video.mp4'),
                'image' => '/frontend/images/lecture.jpg'
            ],
            [
                'ar' => [
                    'title' => 'إجتماع أطباء الأسنان 2',
                ],
                'en' => [
                    'title' => '2 Dentists meeting',
                ],
                'category_id' => 2,
                'link' => asset('frontend/videos/video.mp4'),
                'image' => '/frontend/images/lecture.jpg'
            ],
            [
                'ar' => [
                    'title' => 'إجتماع أطباء الأسنان 3',
                ],
                'en' => [
                    'title' => '3 Dentists meeting',
                ],
                'category_id' => 3,
                'link' => asset('frontend/videos/video.mp4'),
                'image' => '/frontend/images/lecture.jpg'
            ],
        ];

        foreach ($lectures as $lecture){

            $data = $lecture;

            unset($data['image']);

            $lectureModel = Lecture::create($data);

            $lectureModel->addMediaFromUrl(public_path($lecture['image']), 'lecture_image');
        }
    }
}
