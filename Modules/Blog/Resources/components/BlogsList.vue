<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-1">
                    <div class="input-group  search-area d-xl-inline-flex  mr-1" >
                        <input type="text" v-on:keyup.enter="fetchBlogs()" class="form-control" placeholder="Search here..." v-model="q">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchBlogs()"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-sm-3 mb-1">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success" :href="route('admin.blogs.create')" title="New"><i class="la la-plus"></i></a>
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
                                <a v-for="blogSort in sorts" v-on:click="changeSort(blogSort)" class="dropdown-item" href="javascript:void(0);"><span :class="'text-'+blogSort.class">{{ blogSort.label }}</span></a>
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
                                    <th>Title</th>
                                    <th>Language</th>
                                    <th>Status</th>
                                    <th>Creation Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="blog in blogs.data" :id="'element_row_' + blog.id">
                                    <td><strong>{{ blog.id }}</strong></td>
                                    <td>
                                        <a :href="blog.blog_image" data-toggle="lightbox">
                                            <img class="p-4 width130" :src="blog.blog_image" />
                                        </a>
                                    </td>
                                    <td>{{ blog.title }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm">{{ blog.locale }}</button>
                                    </td>
                                    <td>
                                        <span :id="'element_span_' + blog.id" v-bind:class="blog.statusData.class" class="badge">
                                            {{ blog.statusData.label }}
                                        </span>
                                    </td>
                                    <td>{{ moment(blog.created_at).format('DD MMM YYYY, hh:mm A') }}</td>
                                    <td>
                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="change status"
                                                :id="'btn_change_element_status_' + blog.id"
                                                :data-url="route('api.blog.status', {blog: blog.id})"
                                                v-on:click="openStatusModal(blog.id)"
                                                v-bind:class="blog.statusData.btn_class"
                                                class="light sharp btn btn-icon mr-1">
                                            <i v-bind:class="blog.statusData.btn_icon"></i>
                                        </button>

                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="delete blog"
                                                :data-url="route('api.blog.destroy', {blog: blog.id})"
                                                :id="'btn_delete_element_' + blog.id"
                                                v-on:click="openDeleteModal(blog.id)"
                                                class="light sharp btn btn-danger btn-icon mr-1">
                                            <i class="fa fa-trash-o"></i>
                                        </button>

                                        <a :href="route('admin.blogs.edit', {blog: blog.id})" class="light sharp btn btn-info btn-icon mr-1">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <a :href="route('admin.blog-copy', {blog: blog.id})" class="light sharp btn btn-warning btn-icon mr-1">
                                            <i class="fa fa-files-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <delete-modal :name="'blog'"></delete-modal>
                        <status-modal :name="'blog'"></status-modal>

                        <pagination :limit="8" :data="blogs" :show-disabled="true" @pagination-change-page="fetchBlogs">
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
    name: 'blogs-list',
    data: function () {
        return {
            'q' : '',
            'sort': { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
            'blogs' : {},
            'page' : 1,
            'sorts' : []
        }
    },
    created() {
        this.fetchBlogs();
        this.fetchSorts();
    },
    computed: {
    },
    methods: {
        fetchBlogs(page = 1) {
            this.page = page;
            axios
                .get(route('api.blogs.index', {
                    page: page,
                    q : this.q,
                    sort : this.sort.id,
                    direction : this.sort.direction,
                }))
                .then(response => {
                    this.blogs = response.data;
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
            this.fetchBlogs();
        },
        openDeleteModal(blog_id) {
            $('#delete_btn_submit').attr('data-id', blog_id)

            $('#delete_modal').modal('show');
        },
        openStatusModal(blog_id) {
            $('#change_status_btn_submit').attr('data-id', blog_id)

            $('#change_status_modal').modal('show');
        },
    }
}
</script>
