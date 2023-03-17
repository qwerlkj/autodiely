<template>
    <div class="row my-3 align-items-center">
        <h1 class="col">{{ title }}</h1>
    </div>
    <div class="row my-3 align-items-end">
        <div class="col-8 form-group">
            <label for="search">Search:</label>
            <input id="search" class="form-control" :value="search" @input="(e)=>{search = e.target.value}">

        </div>
        <div class="col">
            <a id="search-link" class="btn btn-outline-dark" :href="`?search=${search}`">Search</a>
        </div>
    </div>
</template>

<script>
export default {
    name: "Header",
    props: ['title'],
    data(){
        return{
            search: (new URLSearchParams(window.location.search)).get('search') || ""
        }
    }
}
</script>

<style scoped>

</style>
