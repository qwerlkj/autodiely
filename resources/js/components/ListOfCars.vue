<script>

import ModalDelete from "@/components/ModalDelete.vue";
import ModalInput from "@/components/ModalInput.vue";
import ModalParts from "@/components/ModalParts.vue";

export default {
    name: "ListOfCars",
    components: {ModalParts, ModalInput, ModalDelete},
    props: ['cars'],
    methods: {
        createCar(data) {
            axios.post('/cars', data).then((resData)=>{
                this.carList.push({...resData.data, parts: []});
                console.log(this.carList)
                this.carFields = this.carFields.map((cf)=>{
                    delete cf.value;
                    delete cf.error;
                    return cf;
                })
            }).catch((e)=>{
                console.log("Error on server when creating")
            })
        },
        deleteCar(){
            axios.delete("/cars/"+this.toDeleteCar);
            this.carList = this.carList.filter((c)=>c.id!==parseInt(this.toDeleteCar))
            this.toDeleteCar = false;
        },
        editCar(data) {
            axios.put('/cars/'+this.toEditCar.toString(), data).then((resData)=>{
                const car = this.carList.find((cl)=>parseInt(cl.id)===parseInt(this.toEditCar));
                car.name = data.name
                car.registration_number = data.registration_number
                car.is_registered = data.is_registered
                console.log(this.carList)
                this.carFields = this.carFields.map((cf)=>{
                    delete cf.value;
                    delete cf.error;
                    return cf;
                })
            }).catch((e)=>{
                console.log("Error on server when creating")
            })
        },
        showEditCar(c){
            this.carFields.find((f)=>f.id==="name").value = c.name;
            this.carFields.find((f)=>f.id==="registration_number").value = c.registration_number;
            this.carFields.find((f)=>f.id==="is_registered").value = c.is_registered;
            this.toEditCar = c.id;
            this.showModalEditCar=true;

        },
        showParts(c){
            this.showModalCarParts = true;
            this.selectedCar=c

        },
    },
    data(){
        return {
            carFields: [
                {'type':'text', 'id':'name', 'label': 'Name', 'required': true},
                {'type':'text', 'id':'registration_number', 'label': 'Registration number', 'required': 'is_registered', 'errorText': "If \"is registered\" is checked, registration number should be filled!"},
                {'type':'checkbox', 'id':'is_registered', 'label': 'Is registered?'},
            ],
            toDeleteCar: 0,
            showModalDeleteCar: false,
            showModalAddCar: false,
            showModalEditCar: false,
            showModalCarParts: false,
            toEditCar: 0,
            selectedCar: undefined,
            deleteName: "",
            carList: JSON.parse(this.cars),
        }
    }
}

</script>
<template>
        <div class="col text-end">
            <button class="btn btn-secondary" @click="showModalAddCar=true">Add Car</button>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Registration number</th>
                    <th>Is registered?</th>
                    <th>Parts</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="car in carList" :key="car.id">
                    <td>{{ car.id }}</td>
                    <td>{{ car.name }}</td>
                    <td>{{ car.registration_number }}</td>
                    <td>{{ car.is_registered === 1 ? "true": "false" }}</td>
                    <td>{{ car.parts?.length || 0}} <a role="button" @click="showParts(car)"><i class="bi bi-eye"></i></a></td>
                    <td>
                        <a class="col-6" role="button" @click="showEditCar(car)"><i class="bi bi-pencil-fill text-black"></i></a>
                        <a class="col-6" role="button" @click="toDeleteCar=`${car.id}`; deleteName=car.name; showModalDeleteCar=true;"><i class="bi bi-trash-fill text-danger"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <ModalDelete v-if="showModalDeleteCar" @close="showModalDeleteCar = false" @onSubmit="deleteCar" :name="deleteName"></ModalDelete>
        <ModalInput v-if="showModalAddCar" @close="showModalAddCar = false" :fields=carFields @onSubmit="createCar" submitText="Create" title="Create new car"></ModalInput>
        <ModalInput v-if="showModalEditCar" @close="showModalEditCar = false" :fields=carFields @onSubmit="editCar" submitText="Edit" :title="`Edit car: ${toEditCar}`"></ModalInput>
        <ModalParts v-if="showModalCarParts" @close="showModalCarParts = false" :car=selectedCar :title="`Edit parts of car: ${selectedCar?.name}`"></ModalParts>
</template>


<style scoped>

</style>
