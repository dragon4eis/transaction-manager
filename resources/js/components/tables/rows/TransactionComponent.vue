<template>
    <tr :class="className">
        <th scope="row" v-text="transaction.id"></th>
        <td class="fixed-width">
            <user-name-edit :form="account" field="name"></user-name-edit>
        </td>
        <td class="fixed-width">
            <type-edit :form="transaction" field="type"></type-edit>
        </td>
        <td class="fixed-width">
            <amount-edit :form="transaction" field="amount"></amount-edit>
        </td>
        <td>
            <button class="btn btn-danger btn-sm"
                    :disabled="disableNav"
                    @click="removeTransaction"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </td>
    </tr>
</template>

<script>
import AmountEdit from "../../forms/edit/AmountEdit";
import TypeEdit from "../../forms/edit/TypeEdit";
import UserNameEdit from "../../forms/edit/UserNameEdit";
export default {
    name: "tr-transaction-component",
    components: {UserNameEdit, TypeEdit, AmountEdit},
    props: {
        transaction: {
            required: true
        }
    },
    computed: {
        className() {
            return this.transaction.type === 1 ? "table-success" : "table-danger"
        },
        type() {
            return this.transaction.type === 1 ? "Credit" : "Debit"
        },
        account() {
            if(!  this.$store.state.accounts.resources.isAllLoading){
                let account = this.$store.getters['accounts/getUserName'](this.transaction.account_id);
                return {balance: account.balance, name: account.user.name, id: this.transaction.account_id} || null
            } else {
                return {balance: this.transaction.balance, name: this.transaction.user, id: this.transaction.account_id} || null
            }
        },
        disableNav(){
            return this.$store.getters['transactions/isFormLoading']
        }
    },
    methods:{
        removeTransaction(){
            this.$store.dispatch('transactions/deleteElement', this.transaction.id)
                .then(() =>{
                    this.$store.dispatch('accounts/updateResource', this.transaction.account_id)
                })
        }
    }
}
</script>

<style scoped>
    .fixed-width {
        width: 300px;
    }
</style>