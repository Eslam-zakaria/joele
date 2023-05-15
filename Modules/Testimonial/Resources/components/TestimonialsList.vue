<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-1">
                    <div class="input-group  search-area d-xl-inline-flex  mr-1" >
                        <input type="text" v-on:keyup.enter="fetchTestimonials()" class="form-control" placeholder="Search here..." v-model="q">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchTestimonials()"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-sm-3 mb-1">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success" :href="route('admin.testimonials.create')" title="New"><i class="la la-plus"></i></a>
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
                                <a v-for="testimonialSort in sorts" v-on:click="changeSort(testimonialSort)" class="dropdown-item" href="javascript:void(0);"><span :class="'text-'+testimonialSort.class">{{ testimonialSort.label }}</span></a>
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
                                <th class="text-center">Name</th>
                                <th class="text-center">Rating</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="testimonial in testimonials.data" :id="'element_row_' + testimonial.id">
                                <td class="text-center"><strong>{{ testimonial.id }}</strong></td>
                                <td class="text-center">{{ testimonial.name }}</td>
                                <td class="text-center">
                                    <i class="fa fa-star text-warning" v-for='index in testimonial.rating'></i>
                                </td>
                                <td class="text-center">
                                    <span :id="'element_span_' + testimonial.id" v-bind:class="testimonial.statusData.class" class="badge">
                                        {{ testimonial.statusData.label }}
                                    </span>
                                </td>
                                <td class="text-center">{{ moment(testimonial.created_at).format('DD MMM YYYY, hh:mm A') }}</td>
                                <td>
                                    <button type="button"
                                            data-placement="top"
                                            data-toggle="tooltip"
                                            title="change status"
                                            :id="'btn_change_element_status_' + testimonial.id"
                                            :data-url="route('api.testimonial.status', {testimonial: testimonial.id})"
                                            v-on:click="openStatusModal(testimonial.id)"
                                            v-bind:class="testimonial.statusData.btn_class"
                                            class="light sharp btn btn-icon mr-1">
                                        <i v-bind:class="testimonial.statusData.btn_icon"></i>
                                    </button>

                                    <button type="button"
                                            data-placement="top"
                                            data-toggle="tooltip"
                                            title="delete testimonial"
                                            :data-url="route('api.testimonial.destroy', {testimonial: testimonial.id})"
                                            :id="'btn_delete_element_' + testimonial.id"
                                            v-on:click="openDeleteModal(testimonial.id)"
                                            class="light sharp btn btn-danger btn-icon mr-1">
                                        <i class="fa fa-trash-o"></i>
                                    </button>

                                    <a :href="route('admin.testimonials.edit', {testimonial: testimonial.id})" class="light sharp btn btn-info btn-icon mr-1">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <delete-modal :name="'testimonial'"></delete-modal>
                        <status-modal :name="'testimonial'"></status-modal>

                        <pagination :limit="8" :data="testimonials" :show-disabled="true" @pagination-change-page="fetchTestimonials">
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
    name: 'testimonials-list',
    data: function () {
        return {
            'q' : '',
            'sort': { 'id' : 'testimonials.created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
            'testimonials' : {},
            'page' : 1,
            'sorts' : []
        }
    },
    created() {
        this.fetchTestimonials();
        this.fetchSorts();
    },
    computed: {
    },
    methods: {
        fetchTestimonials(page = 1) {
            this.page = page;
            axios
                .get(route('api.testimonials.index', {
                    page: page,
                    q : this.q,
                    sort : this.sort.id,
                    direction : this.sort.direction,
                }))
                .then(response => {
                    this.testimonials = response.data;
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
            this.fetchTestimonials();
        },
        openDeleteModal(testimonial_id) {
            $('#delete_btn_submit').attr('data-id', testimonial_id)

            $('#delete_modal').modal('show');
        },
        openStatusModal(testimonial_id) {
            $('#change_status_btn_submit').attr('data-id', testimonial_id)

            $('#change_status_modal').modal('show');
        },
    }
}
</script>
