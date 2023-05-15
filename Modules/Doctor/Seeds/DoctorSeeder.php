<?php

namespace Modules\Doctor\Seeds;


use Illuminate\Database\Seeder;
use Modules\Doctor\Models\Doctor;
use Modules\Doctor\Models\DoctorExperience;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctors =
            [
                [
                    'ar' => [
                        'name'  => 'الدكتور الاول',
                        'slug'  => 'الدكتور-الاول',
                        'experience_years'  => '+5 سنوات',
                        'description' => 'لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوالوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا',
                    ],
                    'en' => [
                        'name'  => 'doctor first',
                        'slug'  => 'first-doctor',
                        'experience_years'  => '+5 years',
                        'description'   => 'Dr.. Abdul-Raouf Al-Ghazali Lorem Epsom Dollar Set Amit, Consector Adaiba Asking Alite, Set de Ayusmod tempur ankidionteut laborit at Magna Dollar Aliquiwallurem Epsom Dollar Set Amit, Consector Adaiba Isking Alite, Sit de Ayosemod Dollar Tempur Labourye Ankidionte',
                    ],
                    'social' => [
                        'instagram' => 'https://www.instagram.com',
                        'youtube' => 'https://www.youtube.com',
                        'facebook' => 'https://www.facebook.com',
                        'twitter' => 'https://twitter.com',
                        'snapchat' => 'https://lens.snapchat.com/',
                        'whats_app' => 'https://wa.me/+966539199115',
                        'email' => 'mohamednagi896@gmail.com',
                    ],
                    'category_id' => 3,
                    'services' => [3],
                    'experience' => [
                        [
                            'en' => [
                                'company_name' => 'hospital 1',
                                'specialization' => 'specialization 1',
                            ],
                            'ar' => [
                                'company_name' => 'المكان 1',
                                'specialization' => 'التخصص 1',
                            ]
                        ],
                        [
                            'en' => [
                                'company_name' => 'hospital 2',
                                'specialization' => 'specialization 2',
                            ],
                            'ar' => [
                                'company_name' => 'المكان 2',
                                'specialization' => 'التخصص 2',
                            ]
                        ],
                    ],
                    'image' => '/frontend/images/doctors/doctor-01.jpg',
                ],
                [
                    'ar' => [
                        'name'       => 'الدكتور الثاني',
                        'slug'       => 'الدكتور-الثاني',
                        'experience_years'  => '+7 سنوات',
                        'description' => 'لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوالوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا',
                    ],
                    'en' => [
                        'name'  => 'second doctor',
                        'slug'  => 'second-doctor',
                        'experience_years'  => '+7 years',
                        'description'   => 'Dr.. Abdul-Raouf Al-Ghazali Lorem Epsom Dollar Set Amit, Consector Adaiba Asking Alite, Set de Ayusmod tempur ankidionteut laborit at Magna Dollar Aliquiwallurem Epsom Dollar Set Amit, Consector Adaiba Isking Alite, Sit de Ayosemod Dollar Tempur Labourye Ankidionte',
                    ],
                    'social' => [
                        'instagram' => 'https://www.instagram.com',
                        'youtube' => 'https://www.youtube.com',
                        'facebook' => 'https://www.facebook.com',
                        'twitter' => 'https://twitter.com',
                        'snapchat' => 'https://lens.snapchat.com/',
                        'whats_app' => 'https://wa.me/+966539199115',
                        'email' => 'mohamednagi896@gmail.com',
                    ],
                    'category_id' => 2,
                    'services' => [2],
                    'experience' => [
                        [
                            'en' => [
                                'company_name' => 'hospital 1',
                                'specialization' => 'specialization 1',
                            ],
                            'ar' => [
                                'company_name' => 'المكان 1',
                                'specialization' => 'التخصص 1',
                            ]
                        ],
                        [
                            'en' => [
                                'company_name' => 'hospital 2',
                                'specialization' => 'specialization 2',
                            ],
                            'ar' => [
                                'company_name' => 'المكان 2',
                                'specialization' => 'التخصص 2',
                            ]
                        ],
                    ],
                    'image' => '/frontend/images/doctors/doctor-01.jpg',
                ],
                [
                    'ar' => [
                        'name'  => 'الدكتور الثالث',
                        'slug'  => 'الدكتور-الثالث',
                        'experience_years'  => '+9 سنوات',
                        'description' => 'لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوالوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا',
                    ],
                    'en' => [
                        'name'  => 'third doctor',
                        'slug'  => 'third-doctor',
                        'experience_years'  => '+9 years',
                        'description'   => 'Dr.. Abdul-Raouf Al-Ghazali Lorem Epsom Dollar Set Amit, Consector Adaiba Asking Alite, Set de Ayusmod tempur ankidionteut laborit at Magna Dollar Aliquiwallurem Epsom Dollar Set Amit, Consector Adaiba Isking Alite, Sit de Ayosemod Dollar Tempur Labourye Ankidionte',
                    ],
                    'social' => [
                        'instagram' => 'https://www.instagram.com',
                        'youtube' => 'https://www.youtube.com',
                        'facebook' => 'https://www.facebook.com',
                        'twitter' => 'https://twitter.com',
                        'snapchat' => 'https://lens.snapchat.com/',
                        'whats_app' => 'https://wa.me/+966539199115',
                        'email' => 'mohamednagi896@gmail.com',
                    ],
                    'category_id' => 1,
                    'services' => [1],
                    'experience' => [
                        [
                            'en' => [
                                'company_name' => 'hospital 1',
                                'specialization' => 'specialization 1',
                            ],
                            'ar' => [
                                'company_name' => 'المكان 1',
                                'specialization' => 'التخصص 1',
                            ]
                        ],
                        [
                            'en' => [
                                'company_name' => 'hospital 2',
                                'specialization' => 'specialization 2',
                            ],
                            'ar' => [
                                'company_name' => 'المكان 2',
                                'specialization' => 'التخصص 2',
                            ]
                        ],
                    ],
                    'image' => '/frontend/images/doctors/doctor-01.jpg',
                ],

            ];

        foreach ($doctors as $doctor){

            $data = $doctor;

            unset($data['image']);
            unset($data['social']);
            unset($data['services']);
            unset($data['experience']);

            $doctorModel = Doctor::create($data);

            if (isset($doctor['social']))
                $doctorModel->socialMedia()->create($doctor['social']);

            if( isset($doctor['services']) )
                $doctorModel->services()->attach($doctor['services']);

            foreach ($doctor['experience'] as $experienceData) {

                DoctorExperience::create(array_merge($experienceData, ['doctor_id' => $doctorModel->id]));
            }

            $doctorModel->addMediaFromUrl(public_path($doctor['image']), 'doctor_image');
        }
    }
}
