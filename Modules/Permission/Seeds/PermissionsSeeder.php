<?php

namespace Modules\Permission\Seeds;

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            # Branches permissions.
            [
                'name' => 'list branches',
                'display_name' => 'All branches',
                'group_name' => 'branches'
            ],
            [
                'name' => 'create branch',
                'display_name' => 'Add branch',
                'group_name' => 'branches'
            ],
            [
                'name' => 'edit branch',
                'display_name' => 'Edit branch',
                'group_name' => 'branches'
            ],
            [
                'name' => 'delete branch',
                'display_name' => 'Delete branch',
                'group_name' => 'branches'
            ],

            # Reviews permissions.
            [
                'name' => 'list reviews',
                'display_name' => 'All reviews',
                'group_name' => 'reviews'
            ],
            [
                'name' => 'list review questions',
                'display_name' => 'All review questions',
                'group_name' => 'reviews'
            ],
            [
                'name' => 'create review question',
                'display_name' => 'Add review',
                'group_name' => 'reviews'
            ],
            [
                'name' => 'edit review question',
                'display_name' => 'Edit review',
                'group_name' => 'reviews'
            ],
            [
                'name' => 'delete review question',
                'display_name' => 'Delete review',
                'group_name' => 'reviews'
            ],

            # Offers permissions.
            [
                'name' => 'list offers',
                'display_name' => 'All offers',
                'group_name' => 'offers'
            ],
            [
                'name' => 'create offer',
                'display_name' => 'Add offer',
                'group_name' => 'offers'
            ],
            [
                'name' => 'edit offer',
                'display_name' => 'Edit offer',
                'group_name' => 'offers'
            ],
            [
                'name' => 'delete offer',
                'display_name' => 'Delete offer',
                'group_name' => 'offers'
            ],

            # Blogs permissions.
            [
                'name' => 'list blogs',
                'display_name' => 'All blogs',
                'group_name' => 'blogs'
            ],
            [
                'name' => 'create blog',
                'display_name' => 'Add blog',
                'group_name' => 'blogs'
            ],
            [
                'name' => 'edit blog',
                'display_name' => 'Edit blog',
                'group_name' => 'blogs'
            ],
            [
                'name' => 'delete blog',
                'display_name' => 'Delete blog',
                'group_name' => 'blogs'
            ],

            # Categories permissions.
            [
                'name' => 'list categories',
                'display_name' => 'All categories',
                'group_name' => 'categories'
            ],
            [
                'name' => 'create category',
                'display_name' => 'Add category',
                'group_name' => 'categories'
            ],
            [
                'name' => 'edit category',
                'display_name' => 'Edit category',
                'group_name' => 'categories'
            ],
            [
                'name' => 'delete category',
                'display_name' => 'Delete category',
                'group_name' => 'categories'
            ],

            # Insurance Companies permissions.
            [
                'name' => 'list insurance companies',
                'display_name' => 'All Insurance Companies',
                'group_name' => 'insurance company'
            ],
            [
                'name' => 'create insurance company',
                'display_name' => 'Add insurance company',
                'group_name' => 'insurance company'
            ],
            [
                'name' => 'edit insurance company',
                'display_name' => 'Edit insurance company',
                'group_name' => 'insurance company'
            ],
            [
                'name' => 'delete insurance company',
                'display_name' => 'Delete insurance company',
                'group_name' => 'insurance company'
            ],

            # Doctors permissions.
            [
                'name' => 'list doctors',
                'display_name' => 'All doctors',
                'group_name' => 'doctor'
            ],
            [
                'name' => 'create doctor',
                'display_name' => 'Add doctor',
                'group_name' => 'doctor'
            ],
            [
                'name' => 'edit doctor',
                'display_name' => 'Edit doctor',
                'group_name' => 'doctor'
            ],
            [
                'name' => 'delete doctor',
                'display_name' => 'Delete doctor',
                'group_name' => 'doctor'
            ],

            # Cases permissions.
            [
                'name' => 'list cases',
                'display_name' => 'All cases',
                'group_name' => 'case'
            ],
            [
                'name' => 'create case',
                'display_name' => 'Add case',
                'group_name' => 'case'
            ],
            [
                'name' => 'edit case',
                'display_name' => 'Edit case',
                'group_name' => 'case'
            ],
            [
                'name' => 'delete case',
                'display_name' => 'Delete case',
                'group_name' => 'case'
            ],

            # Lectures permissions.
            [
                'name' => 'list lectures',
                'display_name' => 'All lectures',
                'group_name' => 'lecture'
            ],
            [
                'name' => 'create lecture',
                'display_name' => 'Add lecture',
                'group_name' => 'lecture'
            ],
            [
                'name' => 'edit lecture',
                'display_name' => 'Edit lecture',
                'group_name' => 'lecture'
            ],
            [
                'name' => 'delete lecture',
                'display_name' => 'Delete lecture',
                'group_name' => 'lecture'
            ],

            # Sliders permissions.
            [
                'name' => 'list sliders',
                'display_name' => 'All sliders',
                'group_name' => 'slider'
            ],
            [
                'name' => 'create slider',
                'display_name' => 'Add slider',
                'group_name' => 'slider'
            ],
            [
                'name' => 'edit slider',
                'display_name' => 'Edit Slider',
                'group_name' => 'slider'
            ],
            [
                'name' => 'delete slider',
                'display_name' => 'Delete Slider',
                'group_name' => 'slider'
            ],

            # Testimonials permissions.
            // [
            //     'name' => 'list testimonials',
            //     'display_name' => 'All testimonials',
            //     'group_name' => 'testimonial'
            // ],
            // [
            //     'name' => 'create testimonial',
            //     'display_name' => 'Add testimonial',
            //     'group_name' => 'testimonial'
            // ],
            // [
            //     'name' => 'edit testimonial',
            //     'display_name' => 'Edit testimonial',
            //     'group_name' => 'testimonial'
            // ],
            // [
            //     'name' => 'delete testimonial',
            //     'display_name' => 'Delete testimonial',
            //     'group_name' => 'testimonial'
            // ],

            # Services permissions.
            [
                'name' => 'list services',
                'display_name' => 'All services',
                'group_name' => 'services'
            ],
            [
                'name' => 'create service',
                'display_name' => 'Add service',
                'group_name' => 'services'
            ],
            [
                'name' => 'edit service',
                'display_name' => 'Edit service',
                'group_name' => 'services'
            ],
            [
                'name' => 'delete service',
                'display_name' => 'Delete service',
                'group_name' => 'services'
            ],



            # Booking permissions.
            [
                'name' => 'list booking',
                'display_name' => 'All bookings',
                'group_name' => 'booking'
            ],
            [
                'name' => 'show booking',
                'display_name' => 'Booking details',
                'group_name' => 'booking'
            ],
            [
                'name' => 'booking status',
                'display_name' => 'Booking status',
                'group_name' => 'booking'
            ],
            [
                'name' => 'delete booking',
                'display_name' => 'Delete booking',
                'group_name' => 'booking'
            ],

            # Contact us permissions.
            [
                'name' => 'list contact-us',
                'display_name' => 'All contact us',
                'group_name' => 'contact-us'
            ],
            [
                'name' => 'edit contact-us',
                'display_name' => 'Edit contact us',
                'group_name' => 'contact-us'
            ],
            [
                'name' => 'show contact-us',
                'display_name' => 'contact us details',
                'group_name' => 'contact-us'
            ],
            [
                'name' => 'delete contact-us',
                'display_name' => 'Delete contact us',
                'group_name' => 'contact-us'
            ],

            # Admins permissions.
            [
                'name' => 'list admins',
                'display_name' => 'All admins',
                'group_name' => 'admin'
            ],
            [
                'name' => 'create admin',
                'display_name' => 'Add admin',
                'group_name' => 'admin'
            ],
            [
                'name' => 'edit admin',
                'display_name' => 'Edit admin',
                'group_name' => 'admin'
            ],
            [
                'name' => 'delete admin',
                'display_name' => 'Delete admin',
                'group_name' => 'admin'
            ],
            [
                'name' => 'admin permissions',
                'display_name' => 'Admin permissions',
                'group_name' => 'admin'
            ],

            # SubscriptionForm permissions.
            [
                'name' => 'list subscription-form',
                'display_name' => 'All subscription form',
                'group_name' => 'subscription-form'
            ],
            [
                'name' => 'delete subscription-form',
                'display_name' => 'Delete subscription form',
                'group_name' => 'subscription-form'
            ],

            # Settings permissions.
            [
                'name' => 'settings',
                'display_name' => 'Settings',
                'group_name' => 'settings'
            ],
        ];

        app()['cache']->forget('spatie.permission.cache');

        foreach ($permissions as $permission){
            \Spatie\Permission\Models\Permission::create($permission);
        }
    }
}
