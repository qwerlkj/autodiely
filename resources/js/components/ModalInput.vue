<template>
    <div class="modal fade show bg-black bg-opacity-50" data-bs-backdrop="static" id="delete_car_modal" style="display: block">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{title}}</h5>
                    <button type="button" class="btn-close" @click="$emit('close')"></button>
                </div>
                <div class="modal-body">
                    <CustomInput v-for="field in fields" :field="field"></CustomInput>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="$emit('close')">Close</button>
                    <button type="submit" class="btn btn-secondary" @click="$emit('onSubmit', validateAndSubmit(fields));">
                        {{ submitText }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CustomInput from "@/components/CustomInput.vue";

export default {
    name: "ModalInput",
    components: {CustomInput},
    methods: {
        validateAndSubmit(f){
            let data = f.map((field)=>{
                if(field.required === true){
                    if(document.getElementById(field.id).value === ""){
                        field.error = true;
                        return {[field.id]:false};
                    }
                }else if(field.required === false || field.required === undefined){
                    field.error = false;
                    return {[field.id]:true};
                }else{
                    if(document.getElementById(field.required).type === "checkbox"){
                        if(document.getElementById(field.required).checked){
                            field.error = !document.getElementById(field.id).value !== "";
                            return {[field.id]:document.getElementById(field.id).value !== ""};
                        }

                    }else{
                        field.error = !document.getElementById(field.id).value !== "";
                        return {[field.id]:document.getElementById(field.required).value !== ""};
                    }
                }
                field.error = false;
                return {[field.id]:true};

            });
            data = Object.assign.apply({}, data);
            console.log(data)
            if(Object.values(data).find((i)=>i===false) === undefined){
                return this.getData(f);
            }
        },
        getData(f){
            let data = f.map((field)=>{
                if(field.type === "checkbox"){
                    return {[field.id]: document.getElementById(field.id).checked}
                }
                return {[field.id]: document.getElementById(field.id).value}
            })
            data = Object.assign.apply({}, data)
            console.log(data)
            this.$emit('close');
            return data;
        }
    },
    props: ['fields', 'submitText', 'title'],
}
</script>

<style scoped>

</style>
