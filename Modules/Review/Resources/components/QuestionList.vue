<template>
    <div class="row">
        <div class="table-filters col-md-12 mb-4">
            <div class="row">
                <div class="col-sm-6 col-md-3 mb-1">
                    <div class="input-group  search-area d-xl-inline-flex  mr-1" >
                        <input type="text" v-on:keyup.enter="fetchQuestions()" class="form-control" placeholder="Search here..." v-model="q">
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <a href="javascript:void(0)" v-on:click="fetchQuestions()"><i class="flaticon-381-search-2"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-1 col-sm-3 mb-1">
                    <div class="input-group  d-xl-inline-flex">
                        <a class="btn btn-success" :href="route('admin.reviews-questions.create')" title="New"><i class="la la-plus"></i></a>
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
                                <a v-for="questionSort in sorts" v-on:click="changeSort(questionSort)" class="dropdown-item" href="javascript:void(0);"><span :class="'text-'+questionSort.class">{{ questionSort.label }}</span></a>
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
                                <th>Title</th>
                                <th>Status</th>
                                <th>Creation Date</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="question in questions.data" :id="'element_row_' + question.id">
                                <td><strong>{{ question.id }}</strong></td>
                                <td>{{ question.question }}</td>
                                <td>
                                    <span :id="'element_span_' + question.id" v-bind:class="question.statusData.class" class="badge">
                                        {{ question.statusData.label }}
                                    </span>
                                </td>
                                <td>{{ moment(question.created_at).format('DD MMM YYYY, hh:mm A') }}</td>
                                <td>
                                    <button type="button"
                                            data-placement="top"
                                            data-toggle="tooltip"
                                            title="change status"
                                            :id="'btn_change_element_status_' + question.id"
                                            :data-url="route('api.reviews-questions.status', {review_question: question.id})"
                                            v-on:click="openStatusModal(question.id)"
                                            v-bind:class="question.statusData.btn_class"
                                            class="light sharp btn btn-icon mr-1">
                                        <i v-bind:class="question.statusData.btn_icon"></i>
                                    </button>

                                    <button type="button"
                                            data-placement="top"
                                            data-toggle="tooltip"
                                            title="delete question"
                                            :data-url="route('api.reviews-questions.destroy', {review_question: question.id})"
                                            :id="'btn_delete_element_' + question.id"
                                            v-on:click="openDeleteModal(question.id)"
                                            class="light sharp btn btn-danger btn-icon mr-1">
                                        <i class="fa fa-trash-o"></i>
                                    </button>

                                    <a :href="route('admin.reviews-questions.edit', {reviews_question: question.id})" class="light sharp btn btn-info btn-icon mr-1">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <delete-modal :name="'question'"></delete-modal>
                        <status-modal :name="'question'"></status-modal>

                        <pagination :limit="8" :data="questions" :show-disabled="true" @pagination-change-page="fetchQuestions">
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
    name: 'question-list',
    data: function () {
        return {
            'q' : '',
            'sort': { 'id' : 'created_at', 'direction': 'DESC', 'label' : 'Sort', 'class' : ''},
            'questions' : {},
            'page' : 1,
            'sorts' : []
        }
    },
    created() {
        this.fetchQuestions();
        this.fetchSorts();
    },
    computed: {
    },
    methods: {
        fetchQuestions(page = 1) {
            this.page = page;
            axios
                .get(route('api.reviews-questions.index', {
                    page: page,
                    q : this.q,
                    sort : this.sort.id,
                    direction : this.sort.direction,
                }))
                .then(response => {
                    this.questions = response.data;
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
            this.fetchQuestions();
        },
        openDeleteModal(question_id) {
            $('#delete_btn_submit').attr('data-id', question_id)

            $('#delete_modal').modal('show');
        },
        openStatusModal(question_id) {
            $('#change_status_btn_submit').attr('data-id', question_id)

            $('#change_status_modal').modal('show');
        },
    }
}
</script>
