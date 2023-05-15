<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-1">
                    <div class="input-group  search-area d-xl-inline-flex  mr-1" >
                        <input type="text" v-on:keyup.enter="fetchContacts()" class="form-control" placeholder="Search here..." v-model="q">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchContacts()"><i class="flaticon-381-search-2"></i></a>
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
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="contact in contacts.data" :id="'element_row_' + contact.id">
                                    <td><strong>{{ contact.id }}</strong></td>
                                    <td>{{ contact.name }}</td>
                                    <td>{{ contact.phone}}</td>
                                    <td>{{ contact.topic }}</td>
                                    <td>
                                        <span :id="'element_span_' + contact.id" v-bind:class="contact.statusData.class" class="badge">
                                            {{ contact.statusData.label }}
                                        </span>
                                    </td>
                                    <td>{{ moment(contact.created_at).format('DD MMM YYYY, hh:mm A') }}</td>
                                    <td>
                                        <a class="light sharp btn btn-info btn-icon mr-1" :href="route('admin.contact-us.show', contact.id)">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="Delete contact us"
                                                :data-url="route('api.contact-us.destroy', contact.id)"
                                                :id="'btn_delete_element_' + contact.id"
                                                v-on:click="openDeleteModal(contact.id)"
                                                class="light sharp btn btn-danger btn-icon mr-1">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <delete-modal :name="'contact us'"></delete-modal>

                        <pagination :limit="8" :data="contacts" :show-disabled="true" @pagination-change-page="fetchContacts">
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
        name: 'contact-us-list',
        data: function () {
            return {
                'date_from':'',
                'date_to':'',
                'status_filter':'',
                'source_filter':'',
                'q' : '',
                'sort': { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
                'contacts' : {},
                'page' : 1,
                'sorts' : []
            }
        },
        created() {
            this.fetchContacts();
            this.fetchSorts();
        },
        computed: {
        },
        methods: {
            fetchContacts(page = 1) {
                this.page = page;
                axios
                    .get(route('api.contact-us.index', {
                        page: page,
                        q : this.q,
                        sort : this.sort.id,
                        direction : this.sort.direction,
                    }))
                    .then(response => {
                        this.contacts = response.data;
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
                this.fetchContacts();
            },
            openDeleteModal(contact_id) {
                $('#delete_btn_submit').attr('data-id', contact_id)

                $('#delete_modal').modal('show');
            },
        }
    }
</script>
