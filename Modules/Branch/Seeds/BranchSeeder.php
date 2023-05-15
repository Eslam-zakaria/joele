<?php

namespace Modules\Branch\Seeds;


use Illuminate\Database\Seeder;
use Modules\Branch\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branches = [
            [
                'ar' => [
                    'name'  => 'فرع الحمراء',
                    'slug'  => 'فرع-الحمراء',
                    'address' => 'السعوديه، البساتين الشرقية، قسم البساتين، محافظة القاهرة، مصر',
                ],
                'en' => [
                    'name'  => 'al hamra branch',
                    'slug'  => 'al-hamra-branch',
                    'address' => 'Prince Saud Al Faisal, Jeddah Saudi Arabia',
                ],
                'phone' => '0533333333',
                "categories" => [
                    3 =>  [
                        3
                    ],
                ],
                'offer_image' => 'offer-01.jpg',
                'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3710.58203254707!2d39.16306961562525!3d21.563192574692845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15c3d00d5f203cf5%3A0xd5b77987261d10ab!2z2YXYrNmF2Lkg2KzZiNmK2YQg2KfZhNmF2YXZitiyINin2YTYt9io2Yog2YHZiiDYp9mE2LHZiNi22KkgfCBKb2VsZSBTcGVjaWFsIE1lZGljYWwgQ2VudGVyIGluIFJBV0RBSA!5e0!3m2!1sen!2seg!4v1660716603846!5m2!1sen!2seg',
            ],
            [
                'ar' => [
                    'name'  => 'فرع الروضة',
                    'slug'  => 'فرع-الروضة',
                    'address' => 'السعوديه، البساتين الشرقية، قسم البساتين، محافظة القاهرة، مصر',
                ],
                'en' => [
                    'name'  => 'rawda Branch',
                    'slug'  => 'rawda-Branch',
                    'address' => 'Prince Saud Al Faisal, Jeddah Saudi Arabia',
                ],
                'phone' => '0533333333',
                "categories" => [
                    3 =>  [
                        3
                    ],
                ],
                'offer_image' => 'offer-02.jpg',
                'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3710.58203254707!2d39.16306961562525!3d21.563192574692845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15c3d00d5f203cf5%3A0xd5b77987261d10ab!2z2YXYrNmF2Lkg2KzZiNmK2YQg2KfZhNmF2YXZitiyINin2YTYt9io2Yog2YHZiiDYp9mE2LHZiNi22KkgfCBKb2VsZSBTcGVjaWFsIE1lZGljYWwgQ2VudGVyIGluIFJBV0RBSA!5e0!3m2!1sen!2seg!4v1660716603846!5m2!1sen!2seg',
            ],
            [
                'ar' => [
                    'name'  => 'فرع ينبع',
                    'slug'  => 'فرع-ينبع',
                    'address' => 'السعوديه، البساتين الشرقية، قسم البساتين، محافظة القاهرة، مصر',
                ],
                'en' => [
                    'name'  => 'yanbu branch',
                    'slug'  => 'yanbu-branch',
                    'address' => 'Prince Saud Al Faisal, Jeddah Saudi Arabia',
                ],
                'phone' => '0533333333',
                "categories" => [
                    3 =>  [
                        3
                    ],
                ],
                'offer_image' => 'offer-01.jpg',
                'map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3710.58203254707!2d39.16306961562525!3d21.563192574692845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15c3d00d5f203cf5%3A0xd5b77987261d10ab!2z2YXYrNmF2Lkg2KzZiNmK2YQg2KfZhNmF2YXZitiyINin2YTYt9io2Yog2YHZiiDYp9mE2LHZiNi22KkgfCBKb2VsZSBTcGVjaWFsIE1lZGljYWwgQ2VudGVyIGluIFJBV0RBSA!5e0!3m2!1sen!2seg!4v1660716603846!5m2!1sen!2seg',
            ],
        ];

        foreach ($branches as $branch){

            $data = $branch;

            unset($data['offer_image']);

            unset($data['categories']);

            $branchModel = Branch::create($data);

            # assign categories to branch.
            $branchModel->categories()->attach( array_keys($branch['categories']) );

            # assign services to branch.
            $branchModel->services()->attach( call_user_func_array('array_merge', $branch['categories']) );

            $branchModel->addMediaFromUrl(public_path("frontend/images/offers/" . $branch['offer_image']), 'branch_offer_image');
        }
    }
}
