<?php

namespace Modules\InsuranceCompany\Seeds;

use Illuminate\Database\Seeder;
use Modules\InsuranceCompany\Models\InsuranceCompany;

class InsuranceCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'image' => 'frontend/images/insurance/company-01.jpg',
                'ar' => [
                    'title' => 'ميدجلف',
                    'content' => 'تعد شركة البحر الأبيض المتوسط والخليج للتأمين وإعادة التأمين التعاوني (ميدغلف) واحدة من أكبر شركات التأمين في المملكة ، حيث تقدم مجموعة شاملة من خدمات التأمين وإعادة التأمين التعاوني ، والسيارات ، والممتلكات وغيرها من خدمات التأمين وإعادة التأمين. مرخصة ومسيطر عليها من قبل البنك المركزي السعودي ، رقم الترخيص م / 3/97200 ورأس مال مدفوع 800.000.000 ريال سعودي ورقم سجل تجاري: 101231925',
                ],
                'en' => [
                    'title' => 'MEDGULF',
                    'content' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem, ratione! Numquam, sit? Cumque unde velit dignissimos repudiandae consequuntur rem eligendi.
                                 Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda molestiae eveniet quasi dolorem vero numquam, minus officiis tenetur, magnam dolore nobis aliquam incidunt quod, quisquam placeat sint inventore dignissimos praesentium?',
                ],
            ],
            [
                'image' => 'frontend/images/insurance/company-02.jpg',
                'ar' => [
                    'title' => 'بوبا',
                    'content' => 'تعد شركة البحر الأبيض المتوسط والخليج للتأمين وإعادة التأمين التعاوني (ميدغلف) واحدة من أكبر شركات التأمين في المملكة ، حيث تقدم مجموعة شاملة من خدمات التأمين وإعادة التأمين التعاوني ، والسيارات ، والممتلكات وغيرها من خدمات التأمين وإعادة التأمين. مرخصة ومسيطر عليها من قبل البنك المركزي السعودي ، رقم الترخيص م / 3/97200 ورأس مال مدفوع 800.000.000 ريال سعودي ورقم سجل تجاري: 101231925',
                ],
                'en' => [
                    'title' => 'Bupa',
                    'content' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem, ratione! Numquam, sit? Cumque unde velit dignissimos repudiandae consequuntur rem eligendi.
                                 Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda molestiae eveniet quasi dolorem vero numquam, minus officiis tenetur, magnam dolore nobis aliquam incidunt quod, quisquam placeat sint inventore dignissimos praesentium?',
                ],
            ]
        ];

        foreach ($companies as $company){

            $data = $company;

            unset($data['image']);

            $companyModel = InsuranceCompany::create($data);

            $companyModel->addMediaFromUrl(public_path($company['image']), 'insurance_company_image');
        }
    }
}
