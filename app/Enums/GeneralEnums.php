<?php


namespace App\Enums;


class GeneralEnums
{
    const Contact_Us_Topic = [
        1 => ['ar' => 'شكوى', 'en' => 'complaint'],
        2 => ['ar' => 'اقتراح', 'en' => 'suggestion'],
        3 => ['ar' => 'مشكلة في الدفع', 'en' => 'payment problem'],
        4 => ['ar' => 'اخرى', 'en' => 'other'],
    ];

    # image mimes type.
    const mimesType = 'png,jpg,jpeg';

    # default images.
    const  DEFAULT_IMAGE_ADMIN_PLACEHOLDER = '/assets/custom/images/person.jpg';
    const  DEFAULT_IMAGE_PLACEHOLDER = '/assets/custom/images/placeholder.jpg';
    const  DEFAULT_Video_PLACEHOLDER = '/assets/images/videos-icon.png';


    # for paginate page count.
    const perPage = 8;

    # for days.
    const Days = [
        0 => 'sunday',
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday',
    ];
}
