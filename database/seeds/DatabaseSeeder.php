<?php

use Illuminate\Database\Seeder;
use Modules\Blog\Seeds\BlogSeeder;
use Modules\Cases\Seeds\CasesSeeder;
use Modules\Category\Seeds\CategorySeeder;
use Modules\Comment\Seeds\CommentSeeder;
use Modules\Branch\Seeds\BranchSeeder;
use Modules\Doctor\Seeds\DoctorSeeder;
use Modules\InsuranceCompany\Seeds\InsuranceCompaniesSeeder;
use Modules\Lecture\Seeds\LectureSeeder;
use Modules\Offer\Seeds\OfferSeeder;
use Modules\Permission\Seeds\PermissionsSeeder;
use Modules\Service\Seeds\ServiceSeeder;
use Modules\Review\Seeds\ReviewSeeder;
use Modules\Slider\Seeds\SliderSeeder;
use Modules\Testimonial\Seeds\TestimonialSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(TestimonialSeeder::class);
        $this->call(InsuranceCompaniesSeeder::class);
        $this->call(SliderSeeder::class);
        $this->call(OfferSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(CasesSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(LectureSeeder::class);
    }
}
