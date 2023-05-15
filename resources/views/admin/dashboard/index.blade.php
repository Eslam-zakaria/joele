@extends('admin.layout.base')

@section('title', $settings['website_name'][app()->getLocale() == 'en'  ?  'en' : 'ar'] ?? '')

@section('content')
        <!-- row -->
   <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-primary">
                    <div class="card-body  p-4">
                        <div class="media">
                                <span class="mr-3">
                                    <i class="las la-book"></i>
                                </span>
                            <div class="media-body text-white">
                                <p class="mb-1">Numbers Of Booking</p>
                                <h3 class="text-white">{{ \DB::table('bookings')->where('type', 1)->count() }}</h3>
                                <div class="progress mb-2 bg-secondary">
                                    <div class="progress-bar bg-light" style="width: 0%"></div>
                                </div>
                                <!-- <small>80% Increase in 30 Days</small> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-primary">
                    <div class="card-body  p-4">
                        <div class="media">
                                <span class="mr-3">
                                    <i class="las la-stethoscope"></i>
                                </span>
                            <div class="media-body text-white">
                                <p class="mb-1">Numbers Of Doctors</p>
                                <h3 class="text-white">{{ \DB::table('doctors')->count() }}</h3>
                                <div class="progress mb-2 bg-secondary">
                                    <div class="progress-bar bg-light" style="width: 0%"></div>
                                </div>
                                <!-- <small>50% Increase in 30 Days</small> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-primary">
                    <div class="card-body p-4">
                        <div class="media">
                                <span class="mr-3">
                                    <i class="las la-landmark"></i>
                                </span>
                            <div class="media-body text-white">
                                <p class="mb-1">Numbers Of Offers booking</p>
                                <h3 class="text-white">{{ \DB::table('bookings')->where('type', 2)->count() }}</h3>
                                <div class="progress mb-2 bg-secondary">
                                    <div class="progress-bar bg-light" style="width: 0%"></div>
                                </div>
                                <!-- <small>30% Increase in 30 Days</small> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card bg-primary">
                    <div class="card-body  p-4">
                        <div class="media">
                                <span class="mr-3">
                                    <i class="la la-ambulance"></i>
                                </span>
                            <div class="media-body text-white">
                                <p class="mb-1">Numbers Of Contact Us</p>
                                <h3 class="text-white">{{ \DB::table('contact_us')->count() }}</h3>
                                <div class="progress mb-2 bg-secondary">
                                    <div class="progress-bar bg-light" style="width: 0%"></div>
                                </div>
                                <!-- <small>Based on customers reviews</small> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="col-xl-6">
                <div class="card">
                    <div class="card-header d-sm-flex flex-wrap d-block pb-0 border-0">
                        <div class="mr-auto pr-3">
                            <h4 class="text-black fs-20">Transactions Summary</h4>
                            <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
                        </div>
                        <div class="card-action card-tabs mt-3 mt-sm-0 mt-3 mb-sm-0 mb-3 mt-sm-0">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#Monthly" role="tab" aria-selected="true">
                                        Monthly
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Weekly" role="tab" aria-selected="false">
                                        Weekly
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#Today" role="tab" aria-selected="false">
                                        Today
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="Monthly">
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div id="radialBar" class="orderChart"></div>
                                    </div>
                                    <div class="col-sm-6 mb-sm-0 mb-3 text-center">
                                        <h3 class="fs-28 text-black font-w600">$456,005.56</h3>
                                        <span class="mb-3 d-block">from $500,000.00</span>
                                        <p class="fs-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </p>
                                        <a href="#" class="btn btn-secondary btn-rounded">More Details</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 mb-md-0 mb-3">
                                        <div class="p-3 border rounded">
                                            <h3 class="fs-32 text-black font-w600 mb-1">25</h3>
                                            <span class="fs-18">Pending</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mb-md-0 mb-3">
                                        <div class="p-3 border rounded">
                                            <h3 class="fs-32 text-black font-w600 mb-1">60</h3>
                                            <span class="fs-18">Confirmed</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="p-3 border rounded">
                                            <h3 class="fs-32 text-black font-w600 mb-1">7</h3>
                                            <span class="fs-18">Canceled</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Weekly">
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div id="radialBar2" class="orderChart"></div>
                                    </div>
                                    <div class="col-sm-6 mb-sm-0 mb-3 text-center">
                                        <h3 class="fs-28 text-black font-w600">$150,002.00</h3>
                                        <span class="mb-3 d-block">from $400,000.00</span>
                                        <p class="fs-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </p>
                                        <a href="#" class="btn btn-secondary btn-rounded">More Details</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 mb-md-0 mb-3">
                                        <div class="p-3 border rounded">
                                            <h3 class="fs-32 text-black font-w600 mb-1">30</h3>
                                            <span class="fs-18">On Delivery</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mb-md-0 mb-3">
                                        <div class="p-3 border rounded">
                                            <h3 class="fs-32 text-black font-w600 mb-1">55</h3>
                                            <span class="fs-18">Confirmed</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="p-3 border rounded">
                                            <h3 class="fs-32 text-black font-w600 mb-1">9</h3>
                                            <span class="fs-18">Canceled</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Today">
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div id="radialBar3" class="orderChart"></div>
                                    </div>
                                    <div class="col-sm-6 mb-sm-0 mb-3 text-center">
                                        <h3 class="fs-28 text-black font-w600">$856,005.56</h3>
                                        <span class="mb-3 d-block">from $800,000.00</span>
                                        <p class="fs-14">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do </p>
                                        <a href="#" class="btn btn-secondary btn-rounded">More Details</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 mb-md-0 mb-3">
                                        <div class="p-3 border rounded">
                                            <h3 class="fs-32 text-black font-w600 mb-1">45</h3>
                                            <span class="fs-18">On Delivery</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 mb-md-0 mb-3">
                                        <div class="p-3 border rounded">
                                            <h3 class="fs-32 text-black font-w600 mb-1">90</h3>
                                            <span class="fs-18">Delivered</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="p-3 border rounded">
                                            <h3 class="fs-32 text-black font-w600 mb-1">3</h3>
                                            <span class="fs-18">Canceled</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header d-sm-flex d-block pb-0 border-0">
                        <div class="mr-auto pr-3">
                            <h4 class="text-black fs-20">Revenue</h4>
                            <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
                        </div>
                        <div class="dropdown mt-sm-0 mt-3">
                            <button type="button" class="btn btn-secondary btn-rounded dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Monthly
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="javascript:void(0);">Link 1</a>
                                <a class="dropdown-item" href="javascript:void(0);">Link 2</a>
                                <a class="dropdown-item" href="javascript:void(0);">Link 3</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="user-activity">
                        <div class="d-flex flex-wrap mb-4">
                            <div class="mr-auto mb-2 pr-3 d-flex align-items-center">
                                <svg width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="3.54545" height="26" rx="1.77273" fill="#EA7A9A"/>
                                    <rect x="7.09088" y="7.09082" width="3.54545" height="18.9091" rx="1.77273" fill="#EA7A9A"/>
                                    <rect x="14.1819" y="17.7271" width="3.54545" height="8.27273" rx="1.77273" fill="#EA7A9A"/>
                                    <rect x="21.2727" y="3.54541" width="3.54545" height="22.4545" rx="1.77273" fill="#EA7A9A"/>
                                </svg>
                                <div class="ml-3">
                                    <p class="fs-12 mb-1">Income</p>
                                    <span class="fs-22 text-black font-w600">$126,000</span>
                                </div>
                            </div>
                            <div class="card-action revenue-tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#user" role="tab" aria-selected="true">
                                            All Devices
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#bounce" role="tab" aria-selected="false">
                                            Mastercard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#session-duration" role="tab" aria-selected="false">
                                            Visa
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="user" role="tabpanel">
                                <canvas id="activityLine" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-xxl-12">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header d-sm-flex d-block pb-0 border-0">
                                <div class="mr-auto pr-3">
                                    <h4 class="text-black fs-20">Customer Map</h4>
                                    <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
                                </div>
                                <div class="card-action card-tabs mt-3 mt-sm-0 mt-3 mb-sm-0 mb-3 mt-sm-0">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-selected="true">
                                                Monthly
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tab2" role="tab" aria-selected="false">
                                                Weekly
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#tab3" role="tab" aria-selected="false">
                                                Today
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="tab1">
                                        <div id="chartTimeline"></div>
                                    </div>
                                    <div class="tab-pane fade" id="tab2">
                                        <div id="chartTimeline2"></div>
                                    </div>
                                    <div class="tab-pane fade" id="tab3">
                                        <div id="chartTimeline3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-xxl-12 col-lg-8">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h4 class="text-black fs-20 mb-0">Transactions Summary</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6 mb-sm-0 mb-3">
                                        <div class="media align-items-center">
                                            <div class="d-inline-block mr-3 position-relative donut-chart-sale2">
                                                <span class="donut2" data-peity='{ "fill": ["rgb(84, 205, 81)", "rgba(255, 255, 255, 1)"],   "innerRadius": 27, "radius": 10}'>6/8</span>
                                                <small class="text-black">
                                                    86%
                                                </small>
                                            </div>
                                            <div>
                                                <h4 class="fs-28 font-w600 text-black mb-0">585</h4>
                                                <span>Confirmed Transactions</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="media align-items-center">
                                            <div class="d-inline-block mr-3 position-relative donut-chart-sale2">
                                                <span class="donut2" data-peity='{ "fill": ["rgb(255, 55, 112)", "rgba(255, 255, 255, 1)"],   "innerRadius": 27, "radius": 10}'>3/8</span>
                                                <small class="text-black">
                                                    14%
                                                </small>
                                            </div>
                                            <div>
                                                <h4 class="fs-28 font-w600 text-black mb-0">165</h4>
                                                <span>Rejected Transactions</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-12 col-lg-4">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h4 class="text-black fs-20 mb-0">Ratings</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-end">
                                    <div>
                                        <h4 class="fs-28 font-w600 text-black mb-0">4.9</h4>
                                        <span>Stars</span>
                                    </div>
                                    <canvas class="lineChart" id="chart_widget_2" height="85"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
@endsection

@section('scripts')
    @parent
<!--    <script src="/assets/js/dashboard.js"></script>-->
@endsection
