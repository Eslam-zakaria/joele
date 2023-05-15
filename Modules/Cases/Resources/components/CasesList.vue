<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-1">
                    <div class="input-group  search-area d-xl-inline-flex  mr-1" >
                        <input type="text" v-on:keyup.enter="fetchCases()" class="form-control" placeholder="Search here..." v-model="q">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchCases()"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-sm-3 mb-1">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success" :href="route('admin.cases.create')" title="New"><i class="la la-plus"></i></a>
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
                                <a v-for="caseSort in sorts" v-on:click="changeSort(caseSort)" class="dropdown-item" href="javascript:void(0);"><span :class="'text-'+caseSort.class">{{ caseSort.label }}</span></a>
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
                                <th>Image Before</th>
                                <th>Image After</th>
                                <th>Branch</th>
                                <th>Doctor</th>
                                <th>Status</th>
                                <th>Creation Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="data in cases.data" :id="'element_row_' + data.id">
                                    <td><strong>{{ data.id }}</strong></td>
                                    <td>
                                        <a :href="data.image_before" data-toggle="lightbox">
                                            <img class="p-4 width150 height150" :src="data.image_before"/>
                                        </a>
                                    </td>

                                    <td>
                                        <a :href="data.image_after" data-toggle="lightbox">
                                            <img class="p-4 width150 height150" :src="data.image_after"/>
                                        </a>
                                    </td>

                                    <td>{{ data.branch.name }}</td>
                                    <td>{{ data.doctor.name }}</td>
                                    <td>
                                        <span :id="'element_span_' + data.id" v-bind:class="data.statusData.class" class="badge">
                                            {{ data.statusData.label }}
                                        </span>
                                    </td>

                                    <td>{{ moment(data.created_at).format('DD MMM YYYY, hh:mm A') }}</td>

                                    <td>
                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="change status"
                                                :id="'btn_change_element_status_' + data.id"
                                                :data-url="route('api.case.status', {case: data.id})"
                                                v-on:click="openStatusModal(data.id)"
                                                v-bind:class="data.statusData.btn_class"
                                                class="light sharp btn btn-icon mr-1">
                                            <i v-bind:class="data.statusData.btn_icon"></i>
                                        </button>

                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="delete case"
                                                :data-url="route('api.case.destroy', {case: data.id})"
                                                :id="'btn_delete_element_' + data.id"
                                                v-on:click="openDeleteModal(data.id)"
                                                class="light sharp btn btn-danger btn-icon mr-1">
                                            <i class="fa fa-trash-o"></i>
                                        </button>

                                        <a :href="route('admin.cases.edit', {case: data.id})" class="light sharp btn btn-info btn-icon mr-1">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <a :href="route('admin.case-copy', {case: data.id})" class="light sharp btn btn-warning btn-icon mr-1">
                                            <i class="fa fa-files-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <delete-modal :name="'case'"></delete-modal>
                        <status-modal :name="'case'"></status-modal>

                        <pagination :limit="8" :data="cases" :show-disabled="true" @pagination-change-page="fetchCases">
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
    name: 'cases-list',
    data: function () {
        return {
            'q' : '',
            'sort': { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
            'cases' : {},
            'page' : 1,
            'sorts' : []
        }
    },
    created() {
        this.fetchCases();
        this.fetchSorts();
    },
    computed: {
    },
    methods: {
        fetchCases(page = 1) {
            this.page = page;
            axios
                .get(route('api.cases.index', {
                    page: page,
                    q : this.q,
                    sort : this.sort.id,
                    direction : this.sort.direction,
                }))
                .then(response => {
                    this.cases = response.data;
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
            this.fetchCases();
        },
        openDeleteModal(case_id) {
            $('#delete_btn_submit').attr('data-id', case_id)

            $('#delete_modal').modal('show');
        },
        openStatusModal(case_id) {
            $('#change_status_btn_submit').attr('data-id', case_id)

            $('#change_status_modal').modal('show');
        },
    }
}
</script>
