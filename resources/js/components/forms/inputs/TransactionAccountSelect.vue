<template>
    <div :class="sizeClass">
        <tr-generic-input :editing="editing" @cancel="$emit" @submit="$emit">
            <select class="form-control custom-select" :disabled="disabled" v-model="inputValue" aria-label="client"
                    :class="{'is-invalid': $store.getters['transactions/hasError']('account_id')}"
                    @keydown="$store.commit('transactions/clearError','account_id')">
                <option v-for="account in accounts" :value="account.id" :key="account.id" v-text="account.label"></option>
            </select>
        </tr-generic-input>
        <div v-if="$store.getters['transactions/hasError']('account_id')" class="invalid-feedback d-block">
            <strong v-text="$store.getters['transactions/getError']('account_id')"></strong>
        </div>
    </div>
</template>

<script>
import {input_group} from "../../../mixins";
import TrGenericInput from "./GenericInput";

export default {
    name: "tr-account-select",
    components: {TrGenericInput},
    mixins: [input_group],
    computed:{
        accounts(){
            return this.$store.state.accounts.resources.all.map(account => {return {id: account.id, label: `${account.user.name}($${account.balance})`}}) || [];
        }
    }
}
</script>

<style scoped>

</style>