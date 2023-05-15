<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('admin.dashboard.index') }}" >
                    <i class="la la-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            @can('list blogs')
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                        <i class="la la-blog"></i>
                        <span class="nav-text">Blog</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.blogs.index') }}">Blog</a></li>
                        <li><a href="{{ route('admin.comments.index') }}">Blogs Comments</a></li>
                    </ul>
                </li>
            @endcan

            @can('list lectures')
                <li>
                    <a href="{{ route('admin.lectures.index') }}">
                        <i class="fa fa-list"></i>
                        <span class="nav-text">Lectures</span>
                    </a>
                </li>
            @endcan

            @can('list offers')
                <li>
                    <a href="{{ route('admin.offers.index') }}">
                        <i class="fa fa-list"></i>
                        <span class="nav-text">Offers</span>
                    </a>
                </li>
            @endcan

            @can('list doctors')
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                        <i class="fa fa-user-md"></i>
                        <span class="nav-text">Doctors</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.doctors.index') }}">Doctors</a></li>
                        <li><a href="{{ route('admin.specializations.index') }}">Specializations</a></li>
                    </ul>
                </li>
            @endcan

            @can('list booking')
            <li>
                <a href="{{ route('admin.bookings.index') }}" >
                    <i class="las la-book"></i>
                    <span class="nav-text">Bookings</span>
                </a>
            </li>
            @endcan

            @can('list cases')
                <li>
                    <a href="{{ route('admin.cases.index') }}" >
                        <i class="las la-list"></i>
                        <span class="nav-text">Cases</span>
                    </a>
                </li>
            @endcan

            @can('list reviews')
                <li>
                    <a href="{{ route('admin.reviews.index') }}">
                        <i class="la la-recycle"></i>
                        <span class="nav-text">Reviews</span>
                    </a>
                </li>
            @endcan

            @can('list branches')
                <li>
                    <a href="{{ route('admin.branches.index') }}">
                        <i class="las la-landmark"></i>
                        <span class="nav-text">Branches</span>
                    </a>
                </li>
            @endcan

            @can('list categories')
                <li>
                    <a href="{{ route('admin.categories.index') }}">
                        <i class="las la-list"></i>
                        <span class="nav-text">Categories</span>
                    </a>
                </li>
            @endcan

            @can('list services')
                <li>
                    <a href="{{ route('admin.services.index') }}">
                        <i class="fa fa-list"></i>
                        <span class="nav-text">Services</span>
                    </a>
                </li>
            @endcan

            @can('list insurance companies')
                <li>
                    <a href="{{ route('admin.insurance-companies.index') }}">
                        <i class="las la-list"></i>
                        <span class="nav-text">Insurance Companies</span>
                    </a>
                </li>
            @endcan

            @can('list frequently questions')
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fa fa-user-md"></i>
                    <span class="nav-text">Frequently question</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.questions-category.index') }}">Categories</a></li>
                    <li><a href="{{ route('admin.frequently-questions.index') }}">Frequently question</a></li>
                </ul>
            </li>
            @endcan

            @can('list sliders')
                <li>
                    <a href="{{ route('admin.sliders.index') }}">
                        <i class="la la-image"></i>
                        <span class="nav-text">Slider Images</span>
                    </a>
                </li>
            @endcan

            {{--@can('list testimonials')
                <li>
                    <a href="{{ route('admin.testimonials.index') }}">
                        <i class="la la-comments"></i>
                        <span class="nav-text">Testimonials</span>
                    </a>
                </li>
            @endcan--}}

            @can('list contact-us')
                <li>
                    <a href="{{ route('admin.contact-us.index') }}">
                        <i class="las la-book"></i>
                        <span class="nav-text">Contact Us</span>
                    </a>
                </li>
            @endcan

            @can('list subscription-form')
                <li>
                    <a href="{{ route('admin.subscription-form.index') }}">
                        <i class="las la-list"></i>
                        <span class="nav-text">Subscription form</span>
                    </a>
                </li>
            @endcan

            @can('list admins')
                <li>
                    <a href="{{ route('admin.users.index') }}">
                        <i class="la la-cog"></i>
                        <span class="nav-text">Admins</span>
                    </a>
                </li>
            @endcan

            @can('settings')
                <li>
                    <a href="{{ route('admin.settings.index') }}">
                        <i class="la la-cog"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                </li>
            @endcan

            @can('list redirections urls')
            <li>
                <a href="{{ route('admin.redirections.index') }}">
                    <i class="fa fa-exchange"></i>
                    <span class="nav-text">Redirections URL</span>
                </a>
            </li>
            @endcan
        </ul>

        <div class="copyright">
            <p><strong>Jumppeak Admin Dashboard</strong> © 2020 All Rights Reserved</p>
            <p>Made with <span class="heart"></span> by Jumppeak Team</p>
        </div>
    </div>
</div>
