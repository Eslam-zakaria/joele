<?php

namespace App\Enums;

class CategoriesRelationEnum
{
    const Models = [
        'blogs',
        'services',
        'offers',
        'lectures',
        'cases',
        'branches',
        'doctors',
        'lectures',
    ];

    const GridOptions = [
        1 => ['class' => 'col-md-2', 'name' => '6 items'],
        2 => ['class' => 'col-md-3', 'name' => '4 items'],
        3 => ['class' => 'col-md-4', 'name' => '3 items'],
        4 => ['class' => 'col-md-6', 'name' => '2 items'],
    ];
}
