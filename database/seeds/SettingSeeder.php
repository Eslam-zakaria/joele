<?php

use App\Constants\Templates;
use Modules\Setting\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings =
            [
                [
                    'en' => [
                        'value' => 'Welcome to Joele Clinics!'
                    ],
                    'ar' => [
                        'value' => 'مرحبا بكم في عيادات جويلي!'
                    ],
                    'key' => 'website_name',
                    'translatable' => 2,
                ],
                [
                    'key' => 'email',
                    'other_value' => 'test@test.com'
                ],
                [
                    'key' => 'phone',
                    'other_value' => '01000000000'
                ],
                [
                    'key' => 'facebook',
                    'other_value' => 'facebook.com'
                ],
                [
                    'key' => 'twitter',
                    'other_value' => 'twitter.com'
                ],
                [
                    'key' => 'instagram',
                    'other_value' => 'instagram.com'
                ],
                [
                    'key' => 'snapchat',
                    'other_value' => 'snapchat.com'
                ],
                [
                    'key' => 'youtube',
                    'other_value' => 'youtube.com'
                ],
                [
                    'key' => 'linkedin',
                    'other_value' => 'linkedin.com'
                ],
                [
                    'en' => [
                        'value' => 'Abdullah Bin Abbas St. South Doha, Zahran'
                    ],
                    'ar' => [
                        'value' => 'شارع عبدالله بن عباس جنوب الدوحة ، زهران'
                    ],
                    'key' => 'address',
                    'translatable' => 2,
                ],
                [
                    'en' => [
                        'value' => 'Saturday to Thursday'
                    ],
                    'ar' => [
                        'value' => 'من السبت إلى الخميس'
                    ],
                    'key' => 'working_days',
                    'translatable' => 2,
                ],
                [
                    'key' => 'working_time',
                    'other_value' => '08:00 - 20:00'
                ],
                [
                    'en' => [
                        'value' => 'Saturday to Thursday'
                    ],
                    'ar' => [
                        'value' => 'من السبت إلى الخميس'
                    ],
                    'key' => 'working_days',
                    'translatable' => 2,
                ],
                [
                    'en' => [
                        'value' => 'Friday'
                    ],
                    'ar' => [
                        'value' => 'جمعة'
                    ],
                    'key' => 'day_off',
                    'translatable' => 2,
                ],
                [
                    'en' => [
                        'value' => 'copyright Rights &copy; 2022. All Copyrights Reserved. Joele Clinic'
                    ],
                    'ar' => [
                        'value' => 'حقوق النشر © كل الحقوق محفوظة لـ مجمع جويل الطبي المميز . 2022'
                    ],
                    'key' => 'copyright',
                    'translatable' => 2,
                ],
                [
                    'en' => [
                        'value' => 'We provide high quality medical services through qualified cadres and advanced technology'
                    ],
                    'ar' => [
                        'value' => 'نقدم الخدمات الطبية بجودة عالية من خلال الكوادر المؤهلة والتكنولوجيا المتقدمة'
                    ],
                    'key' => 'about_us_title',
                    'translatable' => 2,
                ],
                [
                    'en' => [
                        'value' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid nostrum, consequatur qui rerum consectetur doloremque possimus similique quae temporibus. Adipisci suscipit perspiciatis eaque. Doloremque commodi excepturi corporis, aliquid minima eveniet.'
                    ],
                    'ar' => [
                        'value' => 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص'
                    ],
                    'key' => 'about_us_content',
                    'translatable' => 2,
                ],

                # Doctor Content.
                [
                    'en' => [
                        'value' => 'A selection of consultants and specialists in all medical specialties'
                    ],
                    'ar' => [
                        'value' => 'نخبة من الإستشاريين والإخصائيين في كافة التخصصات الطبية'
                    ],
                    'key' => 'doctor_content',
                    'translatable' => 2,
                ],

                # Lectures Content.
                [
                    'en' => [
                        'value' => 'A selection of consultants and specialists in all medical specialties'
                    ],
                    'ar' => [
                        'value' => 'نخبة من الإستشاريين والإخصائيين في كافة التخصصات الطبية'
                    ],
                    'key' => 'lectures_content',
                    'translatable' => 2,
                ],

                # Review Content.
                [
                    'en' => [
                        'value' => 'We are distinguished by high quality and the latest advanced technologies in all services'
                    ],
                    'ar' => [
                        'value' => 'نعمل جاهدين من أجل سعادتكم وخدمتكم'
                    ],
                    'key' => 'review_content',
                    'translatable' => 2,
                ],

                # Article content.
                [
                    'en' => [
                        'value' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus, nulla praesentium tenetur voluptate vel possimus
                            minus labore quod veniam totam.'
                    ],
                    'ar' => [
                        'value' => 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.'
                    ],
                    'key' => 'articles_content',
                    'translatable' => 2,
                ],

                # Insurance Companies content.
                [
                    'en' => [
                        'value' => 'We are distinguished by high quality and the latest advanced technologies in all services'
                    ],
                    'ar' => [
                        'value' => 'نعمل جاهدين من أجل سعادتكم وخدمتكم'
                    ],
                    'key' => 'insurance_companies',
                    'translatable' => 2,
                ],

                # About Us home page title.
                [
                    'en' => [
                        'value' => 'Jewel Excellence Medical Complex welcomes you It offers you expertise and efficiency in all services'
                    ],
                    'ar' => [
                        'value' => 'مجمع جويل المميز الطبي يرحب بكم ويقدم لكم الخبرة والكفاءة فى جميع الخدمات'
                    ],
                    'key' => 'about_us_page_title',
                    'translatable' => 2,
                ],

                # About Us Home Page Content.
                [
                    'en' => [
                        'value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id rem ea reiciendis impedit. Officiis ipsam blanditiis, deserunt cumque aspernatur illo voluptas ipsum inventore amet ab veritatis dignissimos velit necessitatibus facilis? Dicta sequi natus
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id rem ea reiciendis impedit. Officiis ipsam blanditiis, deserunt cumque aspernatur illo voluptas ipsum inventore amet ab veritatis dignissimos velit necessitatibus facilis? Dicta sequi natus accusantium ex illo molestiae voluptates voluptatibus autem laborum deserunt et ab est quis mollitia at quae reprehenderit, consequatur provident perspiciatis voluptatem tempore aut explicab.'
                    ],
                    'ar' => [
                        'value' => 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق.
                                    هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص.'
                    ],
                    'key' => 'about_us_page_content',
                    'translatable' => 2,
                ],
                # Mission content.
                [
                    'en' => [
                        'value' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis, nam voluptatum? Maxime dignissimos voluptas atqu.'
                    ],
                    'ar' => [
                        'value' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis, nam voluptatum? Maxime dignissimos voluptas atqu.'
                    ],
                    'key' => 'mission',
                    'translatable' => 2,
                ],

                # Vision content.
                [
                    'en' => [
                        'value' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis, nam voluptatum? Maxime dignissimos voluptas atqu.d'
                    ],
                    'ar' => [
                        'value' => 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص.'
                    ],
                    'key' => 'vision',
                    'translatable' => 2,
                ],

                # Values content.
                [
                    'en' => [
                        'value' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis, nam voluptatum? Maxime dignissimos voluptas atqu'
                    ],
                    'ar' => [
                        'value' => 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص. إن كنت تريد أن تستخدم نص لوريم إيبسوم ما، عليك أن تتحقق أولاً أن ليس هناك أي كلمات أو عبارات محرجة أو غير لائقة مخبأة في هذا النص.'
                    ],
                    'key' => 'message',
                    'translatable' => 2,
                ],

                # Page Booking content.
                [
                    'en' => [
                        'value' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis, nam voluptatum? Maxime dignissimos voluptas atque, placeat aspernatur eveniet, saepe dolor aperiam sit velit porro harum nemo libero.'
                    ],
                    'ar' => [
                        'value' => 'هنالك العديد من الأنواع المتوفرة في مجمع الدوحة الطبي نهتم بالإلتزام وبإحترام كرامة وحقوق المرضى من خلال تقديم الرعاية الطبية والخدمات المساندة بشكل إحترافي'
                    ],
                    'key' => 'page_booking_content',
                    'translatable' => 2,
                ],

                # Page Offer content.
                [
                    'en' => [
                        'value' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis, nam voluptatum? Maxime dignissimos voluptas atque, placeat aspernatur eveniet, saepe dolor aperiam sit velit porro harum nemo libero.'
                    ],
                    'ar' => [
                        'value' => 'هنالك العديد من الأنواع المتوفرة في مجمع الدوحة الطبي نهتم بالإلتزام وبإحترام كرامة وحقوق المرضى من خلال تقديم الرعاية الطبية والخدمات المساندة بشكل إحترافي'
                    ],
                    'key' => 'page_offer_content',
                    'translatable' => 2,
                ],

                # Page installment content.
                [
                    'en' => [
                        'value' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis, nam voluptatum? Maxime dignissimos voluptas atque, placeat aspernatur eveniet, saepe dolor aperiam sit velit porro harum nemo libero.'
                    ],
                    'ar' => [
                        'value' => 'هنالك العديد من الأنواع المتوفرة في مجمع الدوحة الطبي نهتم بالإلتزام وبإحترام كرامة وحقوق المرضى من خلال تقديم الرعاية الطبية والخدمات المساندة بشكل إحترافي'
                    ],
                    'key' => 'page_installment_content',
                    'translatable' => 2,
                ],

                # Services
                [
                    'en' => [
                        'value' => 'Distinguished Services of International Quality'
                    ],
                    'ar' => [
                        'value' => 'خدمات مميزة بجودة عالمية'
                    ],
                    'key' => 'services_page_title',
                    'translatable' => 2,
                ],

                [
                    'en' => [
                        'value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id rem ea reiciendis impedit. Officiis ipsam blanditiis,
                            deserunt cumque aspernatur illo voluptas ipsum inventore amet ab veritatis dignissimos velit necessitatibus facilis? Dicta
                            sequi natus accusantium.'
                    ],
                    'ar' => [
                        'value' => 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.'
                    ],
                    'key' => 'services_page_content',
                    'translatable' => 2,
                ],

                [
                    'en' => [
                        'value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id rem ea reiciendis impedit. Officiis ipsam blanditiis,
                            deserunt cumque aspernatur illo voluptas ipsum.'
                    ],
                    'ar' => [
                        'value' => 'هنالك العديد من الأنواع المتوفرة لنصوص لوريم إيبسوم، ولكن الغالبية تم تعديلها بشكل ما عبر إدخال بعض النوادر أو الكلمات العشوائية إلى النص.'
                    ],
                    'key' => 'cases_content_home',
                    'translatable' => 2,
                ],
            ];

        foreach ($settings as $setting){
            $settingData = new Setting();
            $settingData->fill($setting);
            $settingData->save();
        }
    }
}
