<template>
    <div v-if="field.type === 'checkbox'" class="form-check">
        <label :for="field.id">{{field.label}}</label>
        <input :type="field.type" :id="field.id" class="form-check-input" :required="field.required === true" :checked="field.value">
        <div v-if="field.error" class="text-danger">{{field.errorText || "Should not be empty"}}</div>
    </div>
    <div v-else class="form-group">
        <label :for="field.id">{{field.label}}</label>
        <input :type="field.type" :id="field.id" class="form-control" :required="field.required === true" :value="field.value" @input="e => field.value = e.target.value">
        <div v-if="field.error" class="text-danger">{{field.errorText || "Should not be empty"}}</div>
    </div>
</template>

<script>
export default {
    name: "CustomInput",
    props: ["field"]
}
</script>

<style scoped>

</style>
