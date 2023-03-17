
<template>
    <div class="modal fade show bg-black bg-opacity-50" data-bs-backdrop="static" id="delete_car_modal" style="display: block">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content w-auto" style="min-width: 400px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{title}}</h5>
                    <button type="button" class="btn-close" @click="$emit('close')"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Serial number</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="part in car.parts" :key="part.id">
                            <td>{{ part.id }}</td>
                            <td><input v-if="part.edit" type="text" :value="part.name" @input="e => part.name = e.target.value"><span v-else>{{part.name}}</span></td>
                            <td><input v-if="part.edit" type="text" :value="part.serialnumber" @input="e => part.serialnumber = e.target.value"><span v-else>{{part.serialnumber}}</span></td>
                            <td>
                                <button v-if="part.edit" class="btn btn-primary" role="button" @click="savePart(part)">Save</button>
                                <template v-else>
                                    <a class="col-6" role="button" @click="editPart(part)"><i class="bi bi-pencil-fill text-black"></i></a>
                                    <a class="col-6" role="button" @click="selectedPart = part; showModalDeletePart=true;"><i class="bi bi-trash-fill text-danger"></i></a>
                                </template>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-success" @click="addPart">Add part</button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary" @click="saveAllParts()">Save</button>
                </div>
            </div>
        </div>
    </div>
    <ModalDelete v-if="showModalDeletePart" @close="showModalDeletePart = false" @onSubmit="deletePart" :name="selectedPart?.name"></ModalDelete>
</template>

<script>

import ModalDelete from "@/components/ModalDelete.vue";

export default {
    name: "ModalParts",
    components: {ModalDelete},
    props: ['car', 'title'],
    data(){
        return{
            selectedPart: null,
            showModalDeletePart: false
        }
    },
    methods: {
        editPart(p){
            p.edit = true;
        },
        deletePart(){
            axios.delete('/parts/'+this.selectedPart.id.toString()).then((res)=>{
                this.car.parts = this.car.parts.filter((part)=>part.id !== this.selectedPart.id);
            });
        },
        addPart(){
            this.car.parts.push({id:-1, name: "", serialnumber:"", edit:true})
        },
        savePart(p){

            let method = "post"
            if(p.id !== -1){
                method = "put"
            }
            axios({
                method: method,
                url: p.id === -1 ? "/parts" : "/parts/"+p.id,
                data: {...p, car_id: this.car.id}
            }).then((res)=>{
                delete p.edit;
                if(p.id === -1){
                    p.id = res.data.id;
                }
            }).catch((e)=>{
                this.car.parts = this.car.parts.filter((cp)=>cp.id !== -1);
                console.error(e);
            })
        },
        saveAllParts(){
            this.car.parts.forEach((p)=>{
                this.savePart(p)
            });
            this.$emit('close');
        }
    }
}
</script>

<style scoped>

</style>
