<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-1">
                    <div class="input-group  search-area d-xl-inline-flex  mr-1" >
                        <input type="text" v-on:keyup.enter="fetchServices()" class="form-control" placeholder="Search here..." v-model="q">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchServices()"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-1 col-sm-3 mb-1">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success" :href="route('admin.services.create')" title="New"><i class="la la-plus"></i></a>
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
                                <a v-for="serviceSort in sorts" v-on:click="changeSort(serviceSort)" class="dropdown-item" href="javascript:void(0);"><span :class="'text-'+serviceSort.class">{{ serviceSort.label }}</span></a>
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
                            <tr v-for="service in services.data" :id="'element_row_' + service.id">
                                <td><strong>{{ service.id }}</strong></td>
                                <td>
                                    <a :href="service.service_image" data-toggle="lightbox">
                                        <img class="p-4 width130" :src="service.service_image" />
                                    </a>
                                </td>
                                <td>{{ service.serviceName }}</td>
                                <td>{{ service.category.name }}</td>
                                <td>
                                    <span :id="'element_span_' + service.id" v-bind:class="service.statusData.class" class="badge">
                                        {{ service.statusData.label }}
                                    </span>
                                </td>
                                <td>{{ moment(service.created_at).format('DD MMM YYYY, hh:mm A') }}</td>
                                <td>
                                    <button type="button"
                                            data-placement="top"
                                            data-toggle="tooltip"
                                            title="change status"
                                            :id="'btn_change_element_status_' + service.id"
                                            :data-url="route('api.service.status', {service: service.id})"
                                            v-on:click="openStatusModal(service.id)"
                                            v-bind:class="service.statusData.btn_class"
                                            class="light sharp btn btn-icon mr-1">
                                        <i v-bind:class="service.statusData.btn_icon"></i>
                                    </button>

                                    <button type="button"
                                            data-placement="top"
                                            data-toggle="tooltip"
                                            title="delete service"
                                            :data-url="route('api.service.destroy', {service: service.id})"
                                            :id="'btn_delete_element_' + service.id"
                                            v-on:click="openDeleteModal(service.id)"
                                            class="light sharp btn btn-danger btn-icon mr-1">
                                        <i class="fa fa-trash-o"></i>
                                    </button>

                                    <a :href="route('admin.services.edit', {service: service.id})" class="light sharp btn btn-info btn-icon mr-1">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>

                                    <a :href="route('admin.service-copy', {service: service.id})" class="light sharp btn btn-warning btn-icon mr-1">
                                        <i class="fa fa-files-o"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <delete-modal :name="'service'"></delete-modal>
                        <status-modal :name="'service'"></status-modal>

                        <pagination :limit="8" :data="services" :show-disabled="true" @pagination-change-page="fetchServices">
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
    name: 'services-list',
    data: function () {
        return {
            'q' : '',
            'sort': { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
            'services' : {},
            'page' : 1,
            'sorts' : []
        }
    },
    created() {
        this.fetchServices();
        this.fetchSorts();
    },
    computed: {
    },
    methods: {
        fetchServices(page = 1) {
            this.page = page;
            axios
                .get(route('api.services.index', {
                    page: page,
                    q : this.q,
                    sort : this.sort.id,
                    direction : this.sort.direction,
                }))
                .then(response => {
                    this.services = response.data;
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
            this.fetchServices();
        },
        openDeleteModal(service_id) {
            $('#delete_btn_submit').attr('data-id', service_id)

            $('#delete_modal').modal('show');
        },
        openStatusModal(service_id) {
            $('#change_status_btn_submit').attr('data-id', service_id)

            $('#change_status_modal').modal('show');
        },
    }
}
</script>
