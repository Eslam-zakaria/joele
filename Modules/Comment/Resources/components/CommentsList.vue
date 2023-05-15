<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-1">
                    <div class="input-group  search-area d-xl-inline-flex  mr-1" >
                        <input type="text" v-on:keyup.enter="fetchComments()" class="form-control" placeholder="Search here..." v-model="q">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchComments()"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
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
                                <a v-for="commentSort in sorts" v-on:click="changeSort(commentSort)" class="dropdown-item" href="javascript:void(0);"><span :class="'text-'+commentSort.class">{{ commentSort.label }}</span></a>
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
                                    <th>name</th>
                                    <th>phone</th>
                                    <th>Content</th>
                                    <th>Blog ID</th>
                                    <th>Status</th>
                                    <th>Creation Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="comment in comments.data" :id="'element_row_' + comment.id">
                                    <td><strong>{{ comment.id }}</strong></td>
                                    <td>{{ comment.name }}</td>
                                    <td>{{ comment.phone }}</td>
                                    <td>{{ comment.comment }}</td>
                                    <td>{{ comment.blog_id }}</td>
                                    <td>
                                        <span :id="'element_span_' + comment.id" v-bind:class="comment.statusData.class" class="badge">
                                            {{ comment.statusData.label }}
                                        </span>
                                    </td>
                                    <td>{{ moment(comment.created_at).format('DD MMM YYYY, hh:mm A') }}</td>
                                    <td>
                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="change status"
                                                :id="'btn_change_element_status_' + comment.id"
                                                :data-url="route('api.comment.status', {comment: comment.id})"
                                                v-on:click="openStatusModal(comment.id)"
                                                v-bind:class="comment.statusData.btn_class"
                                                class="light sharp btn btn-icon mr-1">
                                            <i v-bind:class="comment.statusData.btn_icon"></i>
                                        </button>

                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="delete comment"
                                                :data-url="route('api.comment.destroy', {comment: comment.id})"
                                                :id="'btn_delete_element_' + comment.id"
                                                v-on:click="openDeleteModal(comment.id)"
                                                class="light sharp btn btn-danger btn-icon mr-1">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <delete-modal :name="'comment'"></delete-modal>
                        <status-modal :name="'comment'"></status-modal>

                        <pagination :limit="8" :data="comments" :show-disabled="true" @pagination-change-page="fetchComments">
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
    name: 'comments-list',
    data: function () {
        return {
            'q' : '',
            'sort': { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
            'comments' : {},
            'page' : 1,
            'sorts' : []
        }
    },
    created() {
        this.fetchComments();
        this.fetchSorts();
    },
    computed: {
    },
    methods: {
        fetchComments(page = 1) {
            this.page = page;
            axios
                .get(route('api.comments.index', {
                    page: page,
                    q : this.q,
                    sort : this.sort.id,
                    direction : this.sort.direction,
                }))
                .then(response => {
                    this.comments = response.data;
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
            this.fetchComments();
        },
        openDeleteModal(comment_id) {
            $('#delete_btn_submit').attr('data-id', comment_id)

            $('#delete_modal').modal('show');
        },
        openStatusModal(comment_id) {
            $('#change_status_btn_submit').attr('data-id', comment_id)

            $('#change_status_modal').modal('show');
        },
    }
}
</script>
