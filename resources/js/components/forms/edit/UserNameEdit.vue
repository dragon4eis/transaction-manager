<template>
    <span v-if="!edit" v-text="label" @click.double="enableEditing"></span>
    <tr-name-input v-else v-model="inputValue" :editing="edit"
        class="custom-edit pl-0" @cancel="cancelEdit" @submit="submit"></tr-name-input>
</template>

<script>
import {edit_mini_form} from "../../../mixins";
import TrNameInput from "../inputs/UserNameInput";

export default {
    name: "UserNameEdit",
    components: {TrNameInput},
    mixins: [edit_mini_form],
    computed: {
        label(){
            return `${this.form.name}($${this.form.balance})`
        },
    },
    methods: {
        submit() {
            this.$store.dispatch('users/submitForm', {id: this.form.id, [this.field]: this.inputValue})
                .then((response) => {
                    this.$store.dispatch('accounts/updateResource', this.form.id)
                        .then((account) => {
                            this.$root.showSuccessMsg({message: response.data.message})
                            this.$store.commit('transactions/UPDATE_TRANSACTION_NAME', account.data.data)
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

</style>