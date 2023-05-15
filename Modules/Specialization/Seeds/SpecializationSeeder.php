<?php

namespace Modules\Specialization\Seeds;

use Illuminate\Database\Seeder;
use Modules\Specialization\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specializations =
            [
                [
                    'ar' => [
                        'name' => 'طبي',
                    ],
                    'en' => [
                        'name' => 'medical',
                    ],
                ],
                [
                    'ar' => [
                        'name' => 'جلدية',
                    ],
                    'en' => [
                        'name' => 'dermal',
                    ],
                ],
                [
                    'ar' => [
                        'name' => 'الأسنان',
                    ],
                    'en' => [
                        'name' => 'dental',
                    ],
                ],
            ];

        foreach ($specializations as $specialization) {

            Specialization::create($specialization);

        }
    }
}
