<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row">
                <div class="form-group col-md-3 col-sm-3 mb-1">
                    <label for="date">Date From</label>
                    <input type="date" class="form-control" v-model="from" v-on:change="fetchsubscriptions()">
                </div>

                <div class="form-group col-md-3 col-sm-3 mb-1">
                    <label for="date">Date To</label>
                    <input type="date" class="form-control" v-model="to" v-on:change="fetchsubscriptions()">
                </div>

                <div class="col-sm-6 col-md-3 mb-1">
                    <div class="input-group  search-area d-xl-inline-flex  mr-1" >
                        <input type="text" v-on:keyup.enter="fetchsubscriptions()" class="form-control" placeholder="Search here..." v-model="q">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchsubscriptions()"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-2 col-sm-3 mt-4 mb-1" style="margin-top: 30px !important;">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success"
                           :href="route('admin.subscription-form.export', {from:from, to:to, q:q})"
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
                                    <th>#</th>
                                    <th>Phone</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="subscription in subscriptions.data" :id="'element_row_' + subscription.id">
                                    <td><strong>{{ subscription.id }}</strong></td>
                                    <td>{{ subscription.phone}}</td>
                                    <td>{{ moment(subscription.created_at).format('DD MMM YYYY, hh:mm A') }}</td>
                                    <td>
                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="Delete subscription us"
                                                :data-url="route('api.subscription-form.destroy', subscription.id)"
                                                :id="'btn_delete_element_' + subscription.id"
                                                v-on:click="openDeleteModal(subscription.id)"
                                                class="light sharp btn btn-danger btn-icon mr-1">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <delete-modal :name="'subscription form'"></delete-modal>

                        <pagination :limit="8" :data="subscriptions" :show-disabled="true" @pagination-change-page="fetchsubscriptions">
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
        name: 'subscription-us-list',
        data: function () {
            return {
                'from':'',
                'to':'',
                'status_filter':'',
                'source_filter':'',
                'q' : '',
                'sort': { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
                'subscriptions' : {},
                'page' : 1,
                'sorts' : []
            }
        },
        created() {
            this.fetchsubscriptions();
            this.fetchSorts();
        },
        computed: {
        },
        methods: {
            fetchsubscriptions(page = 1) {
                this.page = page;
                axios
                    .get(route('api.subscription-form.index', {
                        page: page,
                        q : this.q,
                        from:this.from,
                        to:this.to,
                        sort : this.sort.id,
                        direction : this.sort.direction,
                    }))
                    .then(response => {
                        this.subscriptions = response.data;
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
                this.fetchsubscriptions();
            },
            openDeleteModal(subscription_id) {
                $('#delete_btn_submit').attr('data-id', subscription_id)

                $('#delete_modal').modal('show');
            },
        }
    }
</script>
