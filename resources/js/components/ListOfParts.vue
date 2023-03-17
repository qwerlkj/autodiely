<script>

import ModalDelete from "@/components/ModalDelete.vue";
import ModalInput from "@/components/ModalInput.vue";
import ModalParts from "@/components/ModalParts.vue";

export default {
    name: "ListOfParts",
    components: {ModalDelete},
    props: ['parts', 'cars'],
    data(){
        return{
            selectedPart: null,
            showModalDeletePart: false,
            partList: JSON.parse(this.parts),
            carList: JSON.parse(this.cars)
        }
    },
    methods: {
        editPart(p){
            p.edit = true;
        },
        deletePart(){
            axios.delete('/parts/'+this.selectedPart.id.toString()).then((res)=>{
                this.partList = this.partList.filter((part)=>part.id !== this.selectedPart.id);
            });
        },
        addPart(){
            this.partList.push({id:-1, name: "", serialnumber:"", edit:true})
        },
        savePart(p){
            console.log(p)
            let method = "post"
            if(p.id !== -1){
                method = "put"
            }
            axios({
                method: method,
                url: p.id === -1 ? "/parts" : "/parts/"+p.id,
                data: {...p, car_id: p.car_id || p.car?.id}
            }).then((res)=>{
                delete p.edit;
                if(p.id === -1){
                    p.id = res.data.id;
                }
                p.car = this.carList.filter((c)=>c.id == (p.car_id || p.car?.id))[0]
            }).catch((e)=>{
                this.partList = this.partList.filter((cp)=>cp.id !== -1);
                console.error(e);
            })
        },
        saveAllParts(){
            this.partList.forEach((p)=>{
                this.savePart(p)
            });
            this.$emit('close');
        }
    }
}
</script>
<template>
    <div class="col text-end">
        <button class="btn btn-success" @click="addPart">Add part</button>
    </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Serial number</th>
                <th>Car</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="part in partList" :key="part.id">
                <td>{{ part.id }}</td>
                <td><input v-if="part.edit" type="text" :value="part.name" @input="e => part.name = e.target.value"><span v-else>{{part.name}}</span></td>
                <td><input v-if="part.edit" type="text" :value="part.serialnumber" @input="e => part.serialnumber = e.target.value"><span v-else>{{part.serialnumber}}</span></td>
                <td>
                    <select v-if="part.edit" class="form-select" @input="e => part.car_id = e.target.value" >
                        <option value="null">No car</option>
                        <option v-for="car in carList" :key="car.id" :value="car.id" :selected="car.id===part.car?.id">{{car.name}}</option>
                    </select>
                    <span v-else>{{part.car?.name}}</span>
                </td>
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
        <ModalDelete v-if="showModalDeletePart" @close="showModalDeletePart = false" @onSubmit="deletePart" :name="selectedPart?.name"></ModalDelete>
</template>


<style scoped>

</style>
