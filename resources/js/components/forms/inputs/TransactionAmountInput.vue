<template>
    <div :class="sizeClass">
        <tr-generic-input :editing="editing" @cancel="$emit" @submit="$emit">
            <span id="basic-addon1" slot="prepend" class="input-group-text">$</span>
            <input slot="default" v-model="inputValue"
                   :class="{'is-invalid': $store.getters['transactions/hasError']('amount')}"
                   :disabled="disabled" aria-label="amount"
                   class="form-control"
                   min="0"
                   placeholder="Set email subject"
                   type="number"
                   @keydown="$store.commit('transactions/clearError','amount')"/>
        </tr-generic-input>
        <div v-if="$store.getters['transactions/hasError']('amount')" class="invalid-feedback d-block">
            <strong v-text="$store.getters['transactions/getError']('amount')"></strong>
        </div>
    </div>

</template>

<script>
import TrGenericInput from "./GenericInput";
import {input_group} from "../../../mixins";

export default {
    name: "tr-amount-input",
    components: {TrGenericInput},
    mixins: [input_group]
}
</script>

<style scoped>

</style>