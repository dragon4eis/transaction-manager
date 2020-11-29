<template>
    <div :class="sizeClass">
        <tr-generic-input :editing="editing" @cancel="$emit('cancel')" @submit="$emit('submit')">
            <input slot="default" v-model="inputValue"
                   :class="{'is-invalid': $store.getters['users/hasError']('name')}"
                   :disabled="disabled" aria-label="name"
                   class="form-control"
                   min="0"
                   placeholder="Set email subject"
                   type="text"
                   @keydown="$store.commit('users/clearError','name')"/>
        </tr-generic-input>
        <div v-if="$store.getters['users/hasError']('name')" class="invalid-feedback d-block">
            <strong v-text="$store.getters['users/getError']('name')"></strong>
        </div>
    </div>
</template>

<script>
import TrGenericInput from "./GenericInput";
import {input_group} from "../../../mixins";

export default {
    name: "tr-name-input",
    components: {TrGenericInput},
    mixins: [input_group]
}
</script>

<style scoped>

</style>