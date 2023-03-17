<template>
    <div class="modal fade show bg-black bg-opacity-50" data-bs-backdrop="static" id="delete_car_modal" style="display: block">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Do you want to delete: {{ name }}?</h5>
                    <button type="button" class="btn-close" @click="$emit('close')"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="$emit('close')">No</button>
                    <button type="submit" class="btn btn-secondary" @click="$emit('onSubmit');$emit('close')">Yes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ModalDelete",
    props:['toDelete', 'name'],
}
</script>

<style scoped>

</style>
