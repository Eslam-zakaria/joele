<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-1">
                    <label for="text_search_input">By Name</label>
                    <div class="input-group  search-area d-xl-inline-flex  mr-1" >
                        <input type="text" v-on:keyup.enter="fetchDoctors()" class="form-control" placeholder="Search here..." v-model="q">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchDoctors()"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-3 col-sm-4 mb-1">
                    <label for="doctors_select">By Branches</label>
                    <select class="form-control" v-on:change="fetchDoctors()" v-model="branch" id="branches_select">
                        <option value="">-- Select --</option>
                        <option v-for="branch in branches" :value="branch.id">{{ branch.name }}</option>
                    </select>
                </div>

                <div class="col-md-1 col-sm-3 mb-1">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success" :href="route('admin.doctors.create')" title="New"><i class="la la-plus"></i></a>
                    </div>
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
                                <a v-for="doctorSort in sorts" v-on:click="changeSort(doctorSort)" class="dropdown-item" href="javascript:void(0);"><span :class="'text-'+doctorSort.class">{{ doctorSort.label }}</span></a>
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
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="doctor in doctors.data" :id="'element_row_' + doctor.id">
                                    <td><strong>{{ doctor.id }}</strong></td>
                                    <td>
                                        <a :href="doctor.doctor_image" data-toggle="lightbox">
                                            <img class="p-4 width130" :src="doctor.doctor_image" />
                                        </a>
                                    </td>
                                    <td>{{ doctor.doctorName }}</td>
                                    <td>{{ doctor.category.name }}</td>
                                    <td>
                                        <span :id="'element_span_' + doctor.id" v-bind:class="doctor.statusData.class" class="badge">
                                            {{ doctor.statusData.label }}
                                        </span>
                                    </td>
                                    <td>{{ moment(doctor.created_at).format('DD MMM YYYY, hh:mm A') }}</td>
                                    <td>
                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="change status"
                                                :id="'btn_change_element_status_' + doctor.id"
                                                :data-url="route('api.doctor.status', {doctor: doctor.id})"
                                                v-on:click="openStatusModal(doctor.id)"
                                                v-bind:class="doctor.statusData.btn_class"
                                                class="light sharp btn btn-icon mr-1">
                                            <i v-bind:class="doctor.statusData.btn_icon"></i>
                                        </button>

                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="delete doctor"
                                                :data-url="route('api.doctor.destroy', {doctor: doctor.id})"
                                                :id="'btn_delete_element_' + doctor.id"
                                                v-on:click="openDeleteModal(doctor.id)"
                                                class="light sharp btn btn-danger btn-icon mr-1">
                                            <i class="fa fa-trash-o"></i>
                                        </button>

                                        <a :href="route('admin.doctor.working-days.index', {doctor: doctor.id})" class="light sharp btn btn-primary btn-icon mr-1">
                                            <i class="fa fa-calendar"></i>
                                        </a>

                                        <a :href="route('admin.doctors.edit', {doctor: doctor.id})" class="light sharp btn btn-info btn-icon mr-1">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <a :href="route('admin.doctor-copy', {doctor: doctor.id})" class="light sharp btn btn-warning btn-icon mr-1">
                                            <i class="fa fa-files-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <delete-modal :name="'doctor'"></delete-modal>
                        <status-modal :name="'doctor'"></status-modal>

                        <pagination :limit="8" :data="doctors" :show-disabled="true" @pagination-change-page="fetchDoctors">
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
    name: 'doctors-list',
    data: function () {
        return {
            'q' : '',
            'sort': { 'id' : 'doctors.created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
            'doctors' : {},
            'page' : 1,
            'sorts' : [],
            'branch' : '',
            'branches' : {},
        }
    },
    created() {
        this.fetchDoctors();
        this.fetchBranches();
        this.fetchSorts();
    },
    computed: {
    },
    methods: {
        fetchDoctors(page = 1) {
            this.page = page;
            axios
                .get(route('api.doctors.get', {
                    page: page,
                    q : this.q,
                    sort : this.sort.id,
                    direction : this.sort.direction,
                    branch : this.branch,
                }))
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
                1: { 'id' : 'id', 'direction': 'DESC', 'label' : 'ID DESC', 'class' : 'dark'},
                2: { 'id' : 'id', 'direction': 'ASC', 'label' : 'ID ASC', 'class' : 'dark'},
            };
        },
        changeSort(sort) {
            this.sort = (sort !== undefined) ? this.sort = sort : '';
            this.fetchDoctors();
        },
        openDeleteModal(doctor_id) {
            $('#delete_btn_submit').attr('data-id', doctor_id)

            $('#delete_modal').modal('show');
        },
        openStatusModal(doctor_id) {
            $('#change_status_btn_submit').attr('data-id', doctor_id)

            $('#change_status_modal').modal('show');
        },
    }
}
</script>
