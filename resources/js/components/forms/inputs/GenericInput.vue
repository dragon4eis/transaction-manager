<template>
    <div class="input-group">
        <div class="input-group-prepend">
            <slot name="prepend"></slot>
        </div>
        <slot>
            <input :aria-label="label" class="form-control"/>
        </slot>
        <div v-if="editing" class="input-group-append">
            <div class="input-group-append">
                <button class="btn btn-outline-success" type="button" @click="$emit('submit')"><i
                    class="fas fa-fw fa-check"></i></button>
                <button class="btn btn-outline-danger" type="button" @click="$emit('cancel')"><i
                    class="fas fa-fw fa-times"></i></button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "tr-generic-input",
    props: {
        label: {
            type: String,
            default: "input"
        },
        editing: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style scoped>

</style>