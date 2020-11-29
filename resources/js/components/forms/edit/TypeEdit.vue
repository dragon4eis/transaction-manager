<template>
    <span v-if="!edit" v-text="label" @click.double="enableEditing"></span>
    <tr-type-select v-else v-model="inputValue" :editing="edit"
                    class="custom-edit pl-0" @cancel="cancelEdit" @submit="submit"></tr-type-select>
</template>

<script>
import {edit_mini_form} from "../../../mixins";
import TrTypeSelect from "../inputs/TransactionTypeSelect";

export default {
    name: "type-edit",
    components: {TrTypeSelect},
    mixins: [edit_mini_form],
    computed: {
        label(){
            return this.form.type === 1 ? "Credit" : "Debit"
        },
    },
    methods: {
        submit() {
            this.$store.dispatch('transactions/submit', {id: this.form.id, [this.field]: this.inputValue})
                .then((response) => {
                    this.$store.dispatch('accounts/updateResource', this.form.account_id)
                        .then(() => {
                            this.$root.showSuccessMsg({message: response.data.message})
                            this.cancelEdit();
                        })
                })
                .catch(error => {
                    console.error(error);
                    this.$root.showErrorMsg({message: error.response.data.message})
                })
        }
    }
}
</script>

<style scoped>
    .custom-edit {
        max-width: 300px
    }
</style>