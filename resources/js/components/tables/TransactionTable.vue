<template>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User(Balance)</th>
            <th scope="col">Type</th>
            <th scope="col">Amount</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <tr-transaction-component v-for="transaction in transactions"
                                  :key="transaction.id"
                                  :transaction="transaction">
        </tr-transaction-component>
        </tbody>
    </table>
</template>

<script>
import TrTransactionComponent from "./rows/TransactionComponent";

export default {
    name: "tr-transaction-table",
    components: {TrTransactionComponent},
    computed: {
        transactions() {
            return this.$store.state.transactions.resources.all
        }
    }
}
</script>

<style scoped>

</style>