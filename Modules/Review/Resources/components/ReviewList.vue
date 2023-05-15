<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row mb-4">
                <div class="form-group col-md-3 col-sm-3 mb-1">
                    <label for="date">Date From</label>
                    <input type="date" class="form-control" v-model="from" v-on:change="fetchReviews()">
                </div>

                <div class="form-group col-md-3 col-sm-3 mb-1">
                    <label for="date">Date To</label>
                    <input type="date" class="form-control" v-model="to" v-on:change="fetchReviews()">
                </div>

                <div class="form-group col-md-3 mb-1">
                    <label for="status">Status</label>
                    <select class="form-control" v-model="status" v-on:change="fetchReviews()">
                        <option value="">--Select--</option>
                        <option value="2">Pending</option>
                        <option value="1">Handled</option>
                    </select>
                </div>

                <div class="form-group col-md-3 col-sm-4 mb-1">
                    <label for="doctors_select">By Doctor</label>
                    <select class="form-control" v-on:change="fetchReviews()" v-model="doctor" id="doctors_select">
                        <option value="">-- Select --</option>
                        <option v-for="doctor in doctors" :value="doctor.id">{{ doctor.name }}</option>
                    </select>
                </div>

                <div class="form-group col-md-3 col-sm-4 mb-1">
                    <label for="doctors_select">By Branches</label>
                    <select class="form-control" v-on:change="fetchReviews()" v-model="branch" id="branches_select">
                        <option value="">-- Select --</option>
                        <option v-for="branch in branches" :value="branch.id">{{ branch.name }}</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-1">
                    <label for="text_search_input">By Name Or Phone</label>
                    <div class="input-group search-area d-xl-inline-flex  mr-1" >

                        <input type="text"
                               v-on:keyup.enter="fetchReviews()"
                               class="form-control"
                               id="text_search_input"
                               placeholder="Search here..."
                               v-model="q" />

                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchReviews()"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-2 col-sm-3 mt-4 mb-1" style="margin-top: 30px !important;">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success" :href="route('admin.reviews-questions.index')" title="New">
                            Questions
                        </a>
                    </div>
                </div>

                <div class="form-group col-md-2 col-sm-3 mt-4 mb-1" style="margin-top: 30px !important;">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success"
                           :href="route('admin.reviews.export', {from:from, to:to, status:status, q:q, branch:branch, doctor:doctor })"
                           title="New" style="width: 100%;">Export</a>
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
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Branch</th>
                                    <th>Doctor</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="review in reviews.data" :id="'element_row_' + review.id">
                                    <td><strong>{{ review.id }}</strong></td>
                                    <td>{{ review.name }}</td>
                                    <td>{{ review.phone}}</td>
                                    <td>{{ review.branch.name }}</td>
                                    <td>{{ review.doctor.name }}</td>
                                    <td>
                                        <span :id="'element_span_' + review.id" v-bind:class="review.statusData.class" class="badge">
                                            {{ review.statusData.label }}
                                        </span>
                                    </td>
                                    <td>{{ moment(review.created_at).format('DD MMM YYYY, hh:mm A') }}</td>
                                    <td>
                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="change status"
                                                :id="'btn_change_element_status_' + review.id"
                                                :data-url="route('api.review.status', {review: review.id})"
                                                v-on:click="openStatusModal(review.id)"
                                                v-bind:class="review.statusData.btn_class"
                                                class="light sharp btn btn-icon mr-1">
                                            <i v-bind:class="review.statusData.btn_icon"></i>
                                        </button>

                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="delete doctor"
                                                :data-url="route('api.review.destroy', {review: review.id})"
                                                :id="'btn_delete_element_' + review.id"
                                                v-on:click="openDeleteModal(review.id)"
                                                class="light sharp btn btn-danger btn-icon mr-1">
                                            <i class="fa fa-trash-o"></i>
                                        </button>

                                        <a :href="route('admin.reviews.edit', {review: review.id})" class="light sharp btn btn-info btn-icon mr-1">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <delete-modal :name="'review'"></delete-modal>
                        <status-modal :name="'review'"></status-modal>

                        <pagination :limit="8" :data="reviews" :show-disabled="true" @pagination-change-page="fetchReviews">
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
    name: 'reviews-list',
    data: function () {
        return {
            'from':'',
            'to':'',
            'status':'',
            'source_filter':'',
            'q' : '',
            'sort': { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
            'reviews' : {},
            'doctors' : {},
            'doctor' : '',
            'branch' : '',
            'branches' : {},
            'page' : 1,
            'sorts' : []
        }
    },
    created() {
        this.fetchReviews();
        this.fetchDoctors();
        this.fetchBranches();
        this.fetchSorts();
    },
    computed: {
    },
    methods: {
        fetchReviews(page = 1) {
            this.page = page;
            axios
                .get(route('api.reviews.index', {
                    page: page,
                    q : this.q,
                    sort : this.sort.id,
                    direction : this.sort.direction,
                    doctor:this.doctor,
                    branch:this.branch,
                    status:this.status,
                    from:this.from,
                    to:this.to,
                }))
                .then(response => {
                    this.reviews = response.data;
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
            this.fetchReviews();
        },
        openDeleteModal(review_id) {
            $('#delete_btn_submit').attr('data-id', review_id)

            $('#delete_modal').modal('show');
        },
        openStatusModal(review_id) {
            $('#change_status_btn_submit').attr('data-id', review_id)

            $('#change_status_modal').modal('show');
        },
    }
}
</script>
