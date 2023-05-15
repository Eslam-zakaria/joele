<?php

namespace App\Services\Sitemap;

use Modules\Blog\Repositories\BlogsRepository;
use Modules\Category\Repositories\CategoriesRepository;
use Modules\Doctor\Repositories\DoctorsRepository;
use Modules\Service\Repositories\ServicesRepository;

class GetSitemapDataService
{
    /**
     * Collect all sitemap data.
     *
     * @return array
     */
    public function collect(): array
    {
        return array_merge($this->blogsMap(), $this->staticPages(), $this->doctorsMap(), $this->categoriesServicesMap(), $this->servicesMap());
    }

    /**
     * Get services categories map.
     *
     * @param array $data
     *
     * @return array
     */
    public function categoriesServicesMap(array $data = []): array
    {
        # Loop in categories data.
        foreach (app(CategoriesRepository::class)->list('services') as $category){

            # Put category arabic data.
            $row_en = [
                'url' => url('services/' . $category->translate('ar')->slug),
                'lastmod' => $category->created_at,
                'priority' => '0.70',
                'type' => 'page',
            ];

            # Put category english data.
            $row_ar = [
                'url' => url('en/services/' . $category->translate('en')->slug),
                'lastmod' => $category->created_at,
                'priority' => '0.70',
                'type' => 'page',
            ];

            # Merge categories data.
            array_push($data, $row_en, $row_ar);
        }

        return $data;
    }

    /**
     * Get services map.
     *
     * @param array $data
     *
     * @return array
     */
    public function servicesMap(array $data = []): array
    {
        # Loop in services data.
        foreach (app(ServicesRepository::class)->all_active() as $service){

            # Put service arabic data.
            $row_en = [
                'url' => url('services-details/' . $service->translate('ar')->slug),
                'lastmod' => $service->created_at,
                'priority' => '0.70',
                'type' => 'page',
            ];

            # Put service english data.
            $row_ar = [
                'url' => url('en/services-details/' . $service->translate('en')->slug),
                'lastmod' => $service->created_at,
                'priority' => '0.70',
                'type' => 'page',
            ];

            # Merge services data.
            array_push($data, $row_en, $row_ar);
        }

        return $data;
    }

    /**
     * Get doctors map.
     *
     * @param array $data
     *
     * @return array
     */
    public function doctorsMap(array $data = []): array
    {
        # Loop in doctors data.
        foreach (app(DoctorsRepository::class)->list() as $doctor){

            # Put doctor arabic data.
            $row_en = [
                'url' => url('doctor/' . $doctor->translate('ar')->slug),
                'lastmod' => $doctor->created_at,
                'priority' => '0.70',
                'type' => 'page',
            ];

            # Put doctor english data.
            $row_ar = [
                'url' => url('en/doctor/' . $doctor->translate('en')->slug),
                'lastmod' => $doctor->created_at,
                'priority' => '0.70',
                'type' => 'page',
            ];

            # Merge doctors data.
            array_push($data, $row_en, $row_ar);
        }

        return $data;
    }

    /**
     * Get blogs map data.
     *
     * @param array $data
     *
     * @return array
     */
    public function blogsMap(array $data = [])
    {
        # Loop in blogs data.
        foreach (app(BlogsRepository::class)->list_active() as $blog){

            # Put blog english data.
            $row_en = [
                'url' => url('blog/' . $blog->slug),
                'title' => $blog->title,
                'date' => $blog->created_at,
                'lang' => 'ar',
                'priority' => '0.80',
                'type' => 'blog',
            ];

            # Put blog arabic data.
            $row_ar = [
                'url' => url('en/blog/' . $blog->slug),
                'title' => $blog->title,
                'date' => $blog->created_at,
                'lang' => 'en',
                'priority' => '0.80',
                'type' => 'blog',
            ];

            # Merge blogs data.
            array_push($data, $row_en, $row_ar);
        }

        return $data;
    }

    /**
     * Get static pages map.
     *
     * @return array[]
     */
    public function staticPages(): array
    {
        return [
            # Home page
            [
                'url' => url('/'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '1.00',
                'type' => 'page',
            ],
            [
                'url' => url('/en'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.88',
                'type' => 'page',
            ],

            # About us page
            [
                'url' => url('about-us'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.80',
                'type' => 'page',
            ],
            [
                'url' => url('en/about-us'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.80',
                'type' => 'page',
            ],

            # frequently asked questions page
            [
                'url' => url('frequently-questions'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.80',
                'type' => 'page',
            ],
            [
                'url' => url('en/frequently-questions'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.80',
                'type' => 'page',
            ],

            # terms & condition
            [
                'url' => url('terms-condition'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.70',
                'type' => 'page',
            ],
            [
                'url' => url('en/terms-condition'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.70',
                'type' => 'page',
            ],

            # Services
            [
                'url' => url('services'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],
            [
                'url' => url('en/services'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],

            # Doctors
            [
                'url' => url('doctors'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],
            [
                'url' => url('en/doctors'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],

            # Cases
            [
                'url' => url('cases'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],
            [
                'url' => url('en/cases'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],

            # Blogs
            [
                'url' => url('blogs'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],
            [
                'url' => url('en/blogs'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],

            # Lectures
            [
                'url' => url('lectures'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],
            [
                'url' => url('en/lectures'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],

            # Branches
            [
                'url' => url('branches'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],
            [
                'url' => url('en/branches'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],

            # Review
            [
                'url' => url('review'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],
            [
                'url' => url('en/review'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],

            # Contact us
            [
                'url' => url('contact-us'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],
            [
                'url' => url('en/contact-us'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],

            # Latest offers
            [
                'url' => url('latest-offers'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],
            [
                'url' => url('en/latest-offers'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],

            # Book an appointment
            [
                'url' => url('book-an-appointment'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],
            [
                'url' => url('en/book-an-appointment'),
                'lastmod' => '2021-01-01T10:57:47+00:00',
                'priority' => '0.75',
                'type' => 'page',
            ],
        ];
    }
}
