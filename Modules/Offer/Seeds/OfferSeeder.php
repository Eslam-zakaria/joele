<?php

namespace Modules\Offer\Seeds;


use Illuminate\Database\Seeder;
use Modules\Offer\Models\Offer;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offers = [
            [
                'ar' => [
                    'name'  => 'العرض الاول'
                ],
                'en' => [
                    'name'  => 'First offer'
                ],
                'price' => '1000',
                'category_id' => 1,
                'image' => 'offer-01.jpg'
            ],
            [
                'ar' => [
                    'name'  => 'العرض الثاني'
                ],
                'en' => [
                    'name'  => 'second offer'
                ],
                'price' => '1100',
                'category_id' => 1,
                'image' => 'offer-02.jpg'
            ],
            [
                'ar' => [
                    'name'  => 'العرض الثالث'
                ],
                'en' => [
                    'name'  => 'third offer'
                ],
                'price' => '1200',
                'category_id' => 2,
                'image' => 'offer-01.jpg'
            ],
            [
                'ar' => [
                    'name'  => 'العرض الرابع'
                ],
                'en' => [
                    'name'  => 'fourth offer'
                ],
                'price' => '1300',
                'category_id' => 2,
                'image' => 'offer-02.jpg'
            ]
        ];

        foreach ($offers as $offer){

            $data = $offer;

            unset($data['image']);

            $offerModel = Offer::create($data);

            $offerModel->addMediaFromUrl(public_path("/frontend/images/offers/" . $offer['image']), 'offer_image');
        }
    }
}
