<template>
    <generic-modal :shown="true"
                   header-classes="border-bottom-0"
                   modal-classes="modal-xl" @close="close" @dismiss="close" @submit="submit">
        <template slot="title">Create new Transaction</template>
        <div slot="body">
            <fieldset>
                <div class="form-group row required">
                    <label class="col-sm-2 col-form-label">Account:</label>
                    <tr-account-select v-model="form.account_id" size-class="col-sm-10"></tr-account-select>
                </div>
                <div class="form-group row required">
                    <label class="col-sm-2 col-form-label">Type:</label>
                    <tr-type-select v-model="form.type" size-class="col-sm-10"></tr-type-select>
                </div>
                <div class="form-group row required">
                    <label class="col-sm-2 col-form-label">Amount:</label>
                    <tr-amount-input v-model="form.amount" size-class="col-sm-10"></tr-amount-input>
                </div>
            </fieldset>
        </div>
    </generic-modal>
</template>

<script>
import GenericModal from "./GenericModal";
import TrAmountInput from "../forms/inputs/TransactionAmountInput";
import TrTypeSelect from "../forms/inputs/TransactionTypeSelect";
import TrAccountSelect from "../forms/inputs/TransactionAccountSelect";

export default {
    name: "tr-new-transaction-modal",
    components: {
        TrAccountSelect,
        TrTypeSelect,
        TrAmountInput,
        GenericModal
    },
    data() {
        return {
            form: {
                account_id: null,
                type: 1,
                amount: 0
            }
        }
    },
    methods: {
        close() {
            this.$router.push({name: 'transaction-index'})
        },
        submit() {
            this.$store.dispatch('transactions/submit', this.form)
                .then((response) => {
                    this.$store.dispatch('accounts/updateResource', this.form.account_id)
                        .then(() => {
                            this.$store.commit('transactions/RESET_SORT');
                            this.$store.commit('transactions/RESET_SEARCH');
                            this.close();
                        })
                })
                .catch(error => {
                    console.error(error);
                    this.$root.showErrorMsg({message: error.response.data.message})
                })
        }
    },
    computed: {
        disabled() {
            return this.$store.getters['transactions/isFormLoading']
        }
    }
}
</script>

<style scoped>

</style>