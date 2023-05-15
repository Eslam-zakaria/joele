<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row">
                <div class="col-md-1 col-sm-3 mb-1">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success" :href="route('admin.redirections.create')" title="New"><i class="la la-plus"></i></a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 mb-1">
                    <div class="input-group search-area d-xl-inline-flex  mr-1" >
                        <input type="text"
                               v-on:keyup.enter="fetchRedirections()"
                               class="form-control"
                               id="text_search_input"
                               placeholder="Search here..."
                               v-model="q" />

                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchRedirections()"><i class="flaticon-381-search-2"></i></a>
                            </span>
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
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Code</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="redirection in redirections.data" :id="'element_row_' + redirection.id">
                                    <td><strong>{{ redirection.id }}</strong></td>
                                    <td>{{ redirection.from }}</td>
                                    <td>{{ redirection.to}}</td>
                                    <td>{{ redirection.code }}</td>
                                    <td>
                                        <span :id="'element_span_' + redirection.id" v-bind:class="redirection.statusData.class" class="badge">
                                            {{ redirection.statusData.label }}
                                        </span>
                                    </td>
                                    <td>{{ moment(redirection.created_at).format('DD MMM YYYY, hh:mm A') }}</td>
                                    <td>
                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="change status"
                                                :id="'btn_change_element_status_' + redirection.id"
                                                :data-url="route('api.redirection.status', {redirection: redirection.id})"
                                                v-on:click="openStatusModal(redirection.id)"
                                                v-bind:class="redirection.statusData.btn_class"
                                                class="light sharp btn btn-icon mr-1">
                                            <i v-bind:class="redirection.statusData.btn_icon"></i>
                                        </button>

                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="delete doctor"
                                                :data-url="route('api.redirection.destroy', {redirection: redirection.id})"
                                                :id="'btn_delete_element_' + redirection.id"
                                                v-on:click="openDeleteModal(redirection.id)"
                                                class="light sharp btn btn-danger btn-icon mr-1">
                                            <i class="fa fa-trash-o"></i>
                                        </button>

                                        <a :href="route('admin.redirections.edit', {redirection: redirection.id})" class="light sharp btn btn-info btn-icon mr-1">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <delete-modal :name="'redirection'"></delete-modal>
                        <status-modal :name="'redirection'"></status-modal>

                        <pagination :limit="8" :data="redirections" :show-disabled="true" @pagination-change-page="fetchRedirections">
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
    name: 'redirections-list',
    data: function () {
        return {
            'from':'',
            'to':'',
            'status':'',
            'source_filter':'',
            'q' : '',
            'sort': { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
            'redirections' : {},
            'doctors' : {},
            'doctor' : '',
            'branch' : '',
            'branches' : {},
            'page' : 1,
            'sorts' : []
        }
    },
    created() {
        this.fetchRedirections();
        this.fetchSorts();
    },
    computed: {
    },
    methods: {
        fetchRedirections(page = 1) {
            this.page = page;
            axios
                .get(route('api.redirections.index', {
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
                    this.redirections = response.data;
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
            this.fetchRedirections();
        },
        openDeleteModal(redirection_id) {
            $('#delete_btn_submit').attr('data-id', redirection_id)

            $('#delete_modal').modal('show');
        },
        openStatusModal(redirection_id) {
            $('#change_status_btn_submit').attr('data-id', redirection_id)

            $('#change_status_modal').modal('show');
        },
    }
}
</script>
