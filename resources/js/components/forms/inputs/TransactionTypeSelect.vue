<template>
    <div :class="sizeClass">
        <tr-generic-input :editing="editing" @cancel="$emit" @submit="$emit">
            <select slot="default" v-model="inputValue"
                    :class="{'is-invalid': $store.getters['transactions/hasError']('type')}" :disabled="disabled" aria-label="Types"
                    class="form-control custom-select"
                    @keydown="$store.commit('transactions/clearError','type')">
                <option v-for="type in types" :key="type.id" :value="type.id" v-text="type.label"></option>
            </select>
        </tr-generic-input>
        <div v-if="$store.getters['transactions/hasError']('type')" class="invalid-feedback d-block">
            <strong v-text="$store.getters['transactions/getError']('type')"></strong>
        </div>
    </div>
</template>

<script>
import TrGenericInput from "./GenericInput";
import {input_group} from "../../../mixins";

export default {
    name: "tr-type-select",
    components: {TrGenericInput},
    mixins: [input_group],
    props: {
        types:{
            type:Array,
            default(){
                return [
                    {id:1, label: "Credit"},
                    {id:2, label: "Debit"},
                ]
            }
        }
    }

}
</script>

<style scoped>

</style>