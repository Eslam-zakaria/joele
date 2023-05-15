<?php

if (! function_exists('paginate')) {
    function paginate($collection) {
        return [
            'pagination' => [
                'total' => $collection->total(),
                'per_page' => $collection->perPage(),
                'current_page' => $collection->currentPage(),
                'last_page' => $collection->lastPage(),
                'from' => $collection->firstItem(),
                'to' => $collection->lastItem()
            ],
            'data' => $collection
        ];
    }
}


if (! function_exists('field')) {
    function field($type, $name, $label, $cols, $form = null, $options = [], $required = false, $multiple = false)
    {
        return [
            'type' => $type,
            'name' => $name,
            'label' => $label,
            'cols' => $cols,
            'form' => $form,
            'options' => $options,
            'required' => $required,
            'multiple' => $multiple,
        ];
    }
}



if (! function_exists('registeredModules')) {
    function registeredModules() {
        return [
            'Setting',
            'Doctor',
            'Service',
            'Offer',
            'Branch',
            'Booking',
            'Blog',
            'Comment',
            'Ticket',
            'Slider',
            'Testimonial',
            'Cases',
            'InsuranceCompany',
            'Review',
            'Permission',
            'Category',
            'ContactUs',
            'SubscriptionForm',
            'Lecture',
            'Specialization',
            'FrequentlyQuestion',
            'Redirection'
            // Pages Module order here should be the last (WildCarding)
        ];
    }
}

if (! function_exists('settings')) {
    function settings()
    {
        return new \Modules\Setting\Services\SettingService();
    }
}



if (! function_exists('direction')) {
    function direction($locale)
    {
        if (app()->getLocale() == 'ar') {
            return 'rtl';
        }

        else return 'ltr';
    }
}


if (! function_exists('trunc')) {
    function trunc($str, $chars, $toSpace, $replacement="...") {
        if($chars > strlen($str)) return $str;

        $str = substr($str, 0, $chars);
        $spacePos = strrpos($str, " ");
        if($toSpace && $spacePos >= 0)
            $str = substr($str, 0, strrpos($str, " "));

        return($str . $replacement);
    }
}

