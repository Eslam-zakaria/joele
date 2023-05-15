<template>
    <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Delete {{ name }}</h5>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="delete_btn_submit" v-on:click="deleteElement">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'delete-modal',
    props: { name },
    methods: {
        deleteElement(event) {

            let model_id = event.target.getAttribute('data-id')
            let route = $('#btn_delete_element_'+ model_id +'').data('url');
            axios
                .delete(route)
                .then(response => {
                    if (response.data.code === 200){

                        $('#delete_modal').modal('hide');

                        $('#element_row_' + model_id).remove();

                        toastr.success( response.data.message , {timeOut: 5000})
                    }
                })
                .catch( error => {

                    $('#delete_modal').modal('hide');

                    toastr.warning(error.response.data.message, {timeOut: 5000})
                });
        }
    }
}
</script>
