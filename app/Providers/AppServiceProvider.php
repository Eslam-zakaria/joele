<?php

namespace App\Providers;

use App\Services\SettingsServices;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Modules\Category\Repositories\CategoriesRepository;
use App\Constants\Statuses;
use Modules\Redirection\Models\Redirection;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        try {
            $settings = app(SettingsServices::class)->list();
            View::share('settings', $settings);

            # Repository to list categories.
            $categoriesHead = app(CategoriesRepository::class)->list('services', ['translation']);
            View::share('categoriesHead', $categoriesHead);

            $blogCategories = app(CategoriesRepository::class)->list('blogs', ['translation']);
            View::share('blogCategories', $blogCategories);

            $lectureCategories = app(CategoriesRepository::class)->list('lectures', ['translation']);
            View::share('lectureCategories', $lectureCategories);

        } catch (\Exception $exception) {

        }

    }
}
