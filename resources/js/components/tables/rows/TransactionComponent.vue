<template>
    <tr :class="className">
        <th scope="row" v-text="transaction.id"></th>
        <td v-text="`${account.name}($${account.balance})`"></td>
        <td v-text="type"></td>
        <td v-text="amount"></td>
        <td>
            <button class="btn btn-danger" @click="$emit('removeTask',index)"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
            let account = this.$store.getters['accounts/getUserName'](this.transaction.account_id);
            return {balance: account.balance, name: account.user.name} || null
        },
        amount(){
            return `${this.transaction.type === 1 ?'+' : '-'}$${this.transaction.amount}`
        }
    }
}
</script>

<style scoped>

</style>