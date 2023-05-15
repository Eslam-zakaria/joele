<?php

namespace App\Http\Controllers;

use Modules\Service\Repositories\ServicesRepository;

class PagesController
{
    /**
     * Get about us page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contactUs()
    {
        # Repository to list services.
        $services = app(ServicesRepository::class)->lastN();

        return view('frontend.pages.about_us', compact('services'));
    }

    /**
     * Get terms condition page.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function termsCondition()
    {
        return view('frontend.pages.terms_condition');
    }
}
