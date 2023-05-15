<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-1">
                    <div class="input-group  search-area d-xl-inline-flex  mr-1" >
                        <input type="text" v-on:keyup.enter="fetchLectures()" class="form-control" placeholder="Search here..." v-model="q">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchLectures()"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-sm-3 mb-1">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success" :href="route('admin.lectures.create')" title="New"><i class="la la-plus"></i></a>
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
                                <a v-for="lectureSort in sorts" v-on:click="changeSort(lectureSort)" class="dropdown-item" href="javascript:void(0);"><span :class="'text-'+lectureSort.class">{{ lectureSort.label }}</span></a>
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
                                    <th>Status</th>
                                    <th>Creation Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="lecture in lectures.data" :id="'element_row_' + lecture.id">
                                    <td><strong>{{ lecture.id }}</strong></td>
                                    <td>
                                        <a :href="lecture.lecture_image" data-toggle="lightbox">
                                            <img class="p-4 width130" :src="lecture.lecture_image" />
                                        </a>
                                    </td>
                                    <td>{{ lecture.title }}</td>
                                    <td>
                                        <span :id="'element_span_' + lecture.id" v-bind:class="lecture.statusData.class" class="badge">
                                            {{ lecture.statusData.label }}
                                        </span>
                                    </td>
                                    <td>{{ moment(lecture.created_at).format('DD MMM YYYY, hh:mm A') }}</td>
                                    <td>
                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="change status"
                                                :id="'btn_change_element_status_' + lecture.id"
                                                :data-url="route('api.lecture.status', {lecture: lecture.id})"
                                                v-on:click="openStatusModal(lecture.id)"
                                                v-bind:class="lecture.statusData.btn_class"
                                                class="light sharp btn btn-icon mr-1">
                                            <i v-bind:class="lecture.statusData.btn_icon"></i>
                                        </button>

                                        <button type="button"
                                                data-placement="top"
                                                data-toggle="tooltip"
                                                title="delete lecture"
                                                :data-url="route('api.lecture.destroy', {lecture: lecture.id})"
                                                :id="'btn_delete_element_' + lecture.id"
                                                v-on:click="openDeleteModal(lecture.id)"
                                                class="light sharp btn btn-danger btn-icon mr-1">
                                            <i class="fa fa-trash-o"></i>
                                        </button>

                                        <a :href="route('admin.lectures.edit', {lecture: lecture.id})" class="light sharp btn btn-info btn-icon mr-1">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <a :href="route('admin.lecture-copy', {lecture: lecture.id})" class="light sharp btn btn-warning btn-icon mr-1">
                                            <i class="fa fa-files-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <delete-modal :name="'lecture'"></delete-modal>
                        <status-modal :name="'lecture'"></status-modal>

                        <pagination :limit="8" :data="lectures" :show-disabled="true" @pagination-change-page="fetchLectures">
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
        name: 'lectures-list',
        data: function () {
            return {
                'q' : '',
                'sort': { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
                'lectures' : {},
                'page' : 1,
                'sorts' : []
            }
        },
        created() {
            this.fetchLectures();
            this.fetchSorts();
        },
        computed: {
        },
        methods: {
            fetchLectures(page = 1) {
                this.page = page;
                axios
                    .get(route('api.lectures.index', {
                        page: page,
                        q : this.q,
                        sort : this.sort.id,
                        direction : this.sort.direction,
                    }))
                    .then(response => {
                        this.lectures = response.data;
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
                this.fetchLectures();
            },
            openDeleteModal(lecture_id) {
                $('#delete_btn_submit').attr('data-id', lecture_id)

                $('#delete_modal').modal('show');
            },
            openStatusModal(lecture_id) {
                $('#change_status_btn_submit').attr('data-id', lecture_id)

                $('#change_status_modal').modal('show');
            },
        }
    }
</script>
