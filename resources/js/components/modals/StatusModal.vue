<template>
    <div class="modal fade" id="change_status_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Change {{ name }} status </h5>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to change status!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="change_status_btn_submit" v-on:click="changeStatus">Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'status-modal',
    props: { name },
    methods: {
        changeStatus(event) {

            let model_id = event.target.getAttribute('data-id')
            let route = $('#btn_change_element_status_'+ model_id +'').data('url');

            axios
                .post(route)
                .then(response => {

                    if (response.data.code === 200) {

                        $('#change_status_modal').modal('hide');

                        $('#btn_change_element_status_' + model_id)
                            .removeClass('btn-success btn-warning')
                            .addClass(response.data.data.statusData.btn_class)
                            .find('i')
                            .removeClass('fa fa-unlock fa fa-lock')
                            .addClass(response.data.data.statusData.btn_icon);

                        $('#element_span_' + model_id)
                            .removeClass('badge-light badge-success')
                            .addClass(response.data.data.statusData.class)
                            .text(response.data.data.statusData.label);

                        toastr.success(response.data.message, {timeOut: 5000})
                    }
                })
                .catch( error => {

                    $('#change_status_modal').modal('hide');

                    toastr.warning(error.response.statusText, {timeOut: 5000})
                });
        }
    }
}
</script>
