<?php

namespace Modules\Cases\Seeds;

use Illuminate\Database\Seeder;
use Modules\Cases\Models\MedicalCase;

class CasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cases =
            [
                [
                    'image_before' => '/frontend/images/before.jpg',
                    'image_after' => '/frontend/images/after.jpg',
                    'doctor_id' => 1,
                    'category_id' => 1,
                    'branch_id' => 1,
                ],
                [
                    'image_before' => '/frontend/images/before.jpg',
                    'image_after' => '/frontend/images/after.jpg',
                    'doctor_id' => 2,
                    'category_id' => 2,
                    'branch_id' => 2,
                ],
                [
                    'image_before' => '/frontend/images/before.jpg',
                    'image_after' => '/frontend/images/after.jpg',
                    'doctor_id' => 3,
                    'category_id' => 3,
                    'branch_id' => 3,
                ]
            ];

        foreach ($cases as $case){
            $data = $case;

            unset($data['image_before']);
            unset($data['image_after']);

            $caseModel = MedicalCase::create($data);

            $caseModel->addMediaFromUrl(public_path($case['image_before']), 'case_before_image');

            $caseModel->addMediaFromUrl(public_path($case['image_after']), 'case_after_image');
        }
    }
}
