<template>
    <tr :class="className">
        <th scope="row" v-text="transaction.id"></th>
        <td v-text="`${account.name}($${account.balance})`"></td>
        <td v-text="type"></td>
        <td v-text="amount"></td>
        <td>
            <button class="btn btn-danger btn-sm"
                    :disabled="disableNav"
                    @click="removeTransaction"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </td>
    </tr>
</template>

<script>
export default {
    name: "tr-transaction-component",
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
                return {balance: account.balance, name: account.user.name} || null
            } else {
                return {balance: this.transaction.balance, name: this.transaction.user} || null
            }

        },
        amount(){
            return `${this.transaction.type === 1 ?'+' : '-'}$${this.transaction.amount}`
        },
        disableNav(){
            return this.$store.state.transactions.formLoading
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

</style>