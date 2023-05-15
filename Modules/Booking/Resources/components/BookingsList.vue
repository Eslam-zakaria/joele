<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row mb-4">
                <div class="form-group col-md-3 col-sm-4 mb-1">
                    <label for="date">Reference ID</label>
                    <input type="text"
                           class="form-control"
                           v-model="reference_id"
                           v-on:change="fetchBookings()" />
                </div>

                <div class="form-group col-md-3 col-sm-4 mb-1">
                    <label for="date">Date From</label>
                    <input type="date"
                           class="form-control"
                           v-model="from"
                           v-on:change="fetchBookings()" />
                </div>

                <div class="form-group col-md-3 col-sm-4 mb-1">
                    <label for="date">Date To</label>
                    <input type="date"
                           class="form-control"
                           v-model="to"
                           v-on:change="fetchBookings()" />
                </div>

                <div class="form-group col-md-3 col-sm-4 mb-1">
                    <label for="booking_for_status_select">Booking For</label>
                    <select class="form-control" v-on:change="fetchBookings()" v-model="type" id="booking_for_status_select">
                        <option value="">-- Select --</option>
                        <option value="1">Doctor</option>
                        <option value="2">Offer</option>
                    </select>
                </div>

                <div class="form-group col-md-2 col-sm-3 mt-4 mb-1" style="margin-top: 30px !important;">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success"
                           :href="route('admin.bookings.export', {date_from:from, date_to:to, status:status, q:q, type:type, branch:branch, doctor:doctor })"
                           title="New" style="width: 100%;">Export</a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-3 mb-1">
                    <label for="text_search_input">By Name Or Phone</label>
                    <div class="input-group  search-area d-xl-inline-flex  mr-1" >

                        <input type="text"
                               v-on:keyup.enter="fetchBookings()"
                               class="form-control"
                               placeholder="Search here..."
                               v-model="q"
                               id="text_search_input" />

                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchBookings()"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-3 col-sm-4 mb-1">
                    <label for="status_select">By Status</label>
                    <select class="form-control" v-on:change="fetchBookings()" v-model="status" id="status_select">
                        <option value="">-- Select --</option>
                        <option value="1">Pending</option>
                        <option value="2">Confirmed</option>
                        <option value="3">Not Answer</option>
                        <option value="4">Canceled</option>
                        <option value="5">Not Confirmed</option>
                    </select>
                </div>

                <div class="form-group col-md-3 col-sm-4 mb-1">
                    <label for="doctors_select">By Doctor</label>
                    <select class="form-control" v-on:change="fetchBookings()" v-model="doctor" id="doctors_select">
                        <option value="">-- Select --</option>
                        <option v-for="doctor in doctors" :value="doctor.id">{{ doctor.name }}</option>
                    </select>
                </div>

                <div class="form-group col-md-3 col-sm-4 mb-1">
                    <label for="doctors_select">By Branches</label>
                    <select class="form-control" v-on:change="fetchBookings()" v-model="branch" id="branches_select">
                        <option value="">-- Select --</option>
                        <option v-for="branch in branches" :value="branch.id">{{ branch.name }}</option>
                    </select>
                </div>

                <div class="col-md-2 col-sm-6 mb-1 ml-auto">
                    <div class="input-group search-area d-xl-inline-flex">
                        <div class="dropdown " style="width: 100%">
                            <a href="javascript:void(0)" :class="'btn-'+sort.class" class="btn btn-rounded " style="width: 100%" data-toggle="dropdown" aria-expanded="false">
                                <i class="las la-sort-amount-down-alt scale5"></i>
                                {{  sort.label }}
                                <i class="las la-angle-down "></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-center">
                                <a v-for="bookingSort in sorts"
                                   v-on:click="changeSort(BookingSort)"
                                   class="dropdown-item"
                                   href="javascript:void(0);">
                                    <span :class="'text-'+bookingSort.class">{{ bookingSort.label }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md text-small">
                            <thead>
                                <tr>
                                    <th class="width10">#</th>
                                    <th>Reference ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Offer</th>
                                    <th>Doctor</th>
                                    <th>Branch</th>
                                    <th>Price</th>
                                    <th>Pay_Type</th>
                                    <th>Status</th>
                                    <th>Avail Time</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="booking in bookings.data" :id="'element_row_' + booking.id">
                                    <td><strong>{{ booking.id }}</strong></td>
                                    <td>{{ booking.order_reference }}</td>
                                    <td>{{ booking.name }}</td>
                                    <td>{{ booking.phone}}<br>
                                        <span class="btn btn-light btn-xxs" v-if="booking.email != null"> {{ booking.email }} </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light" v-if="booking.type == '2'"> {{ booking.offer.name }} </span>

                                        <span class="badge badge-danger" v-else>
                                         غير محدد
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-light" v-if="booking.type == '1'"> {{ booking.doctor.name }} </span>

                                        <span class="badge badge-danger" v-else>
                                         غير محدد
                                        </span>
                                    </td>
                                    <td><span class="badge badge-light"> {{ booking.branch.name }} </span></td>
                                    <td>
                                        <span class="badge badge-success" v-if="booking.type == '2'"> {{ booking.price }} </span>

                                        <span class="badge badge-danger" v-else>
                                         غير محدد
                                        </span>
                                    </td>
                                    <td>{{ booking.payment_type }}
                                        <a href="#" class="btn btn-dark btn-xxs shadow" v-if="booking.payment_type == 'Pay Installment'">{{ booking.type_installment }}</a>
                                    </td>
                                    <td>
                                        <span v-bind:class="booking.statusData.class" class="badge">
                                            {{ booking.statusData.label }}
                                        </span>
                                    </td>
                                    <td>{{ booking.available_time }}</td>
                                    <td>{{ moment(booking.attendance_date).format('DD MMM YYYY') }}</td>
                                    <td>
                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="delete booking"
                                                :data-url="route('api.booking.destroy', {booking: booking.id})"
                                                :id="'btn_delete_element_' + booking.id"
                                                v-on:click="openDeleteModal(booking.id)"
                                                class="light sharp btn btn-danger btn-icon mr-1">
                                            <i class="fa fa-trash-o"></i>
                                        </button>

                                        <a :href="route('admin.bookings.edit', {booking: booking.id})" class="light sharp btn btn-info btn-icon mr-1">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <delete-modal :name="'booking'"></delete-modal>
                        <status-modal :name="'booking'"></status-modal>

                        <pagination :limit="8" :data="bookings" :show-disabled="true" @pagination-change-page="fetchBookings">
                            <span slot="prev-nav">&lt;</span>
                            <span slot="next-nav">&gt;</span>
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'bookings-list',
    data: function () {
        return {
            'q' : '',
            'status':'',
            'reference_id':'',
            'from':'',
            'to':'',
            'type':'',
            'sort': { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
            'bookings' : {},
            'doctor' : '',
            'doctors' : {},
            'branch' : '',
            'branches' : {},
            'page' : 1,
            'sorts' : []
        }
    },
    created() {
        this.fetchDoctors();
        this.fetchBookings();
        this.fetchBranches();
        this.fetchSorts();
    },
    computed: {
    },
    methods: {
        fetchBookings(page = 1) {
            this.page = page;
            axios
                .get(route('api.bookings.index', {
                    page: page,
                    reference_id: this.reference_id,
                    from:this.from,
                    to:this.to,
                    type:this.type,
                    doctor:this.doctor,
                    branch:this.branch,
                    status:this.status,
                    q:this.q,
                    sort : this.sort.id,
                    direction : this.sort.direction,
                }))
                .then(response => {
                    this.bookings = response.data;
                });
        },
        fetchDoctors() {
            axios
                .get(route('api.doctors.list-data'))
                .then(response => {
                    this.doctors = response.data;
                });
        },
        fetchBranches() {
            axios
                .get(route('api.branches.list'))
                .then(response => {
                    this.branches = response.data;
                });
        },
        fetchSorts() {
            this.sorts = {
                1: { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Created DESC', 'class' : 'dark'},
                2: { 'id' : 'created_at', 'direction': 'ASC', 'label' : 'Created ASC', 'class' : 'dark'},
            };
        },
        changeSort(sort) {
            this.sort = (sort !== undefined) ? this.sort = sort : '';
            this.fetchBookings();
        },
        openDeleteModal(booking_id) {
            $('#delete_btn_submit').attr('data-id', booking_id)

            $('#delete_modal').modal('show');
        },
        openStatusModal(booking_id) {
            $('#change_status_btn_submit').attr('data-id', booking_id)

            $('#change_status_modal').modal('show');
        },
    }
}
</script>
