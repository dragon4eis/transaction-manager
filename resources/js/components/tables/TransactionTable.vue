<template>
    <div v-if="loading" class="text-center text-muted col-12">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <table class="table table-sm" v-else>
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
    props: {
        transactions: {
            required: true
        }
    },
    computed:{
        loading(){
            return this.$store.state.transactions.resources.isAllLoading
        }
    }
}
</script>

<style scoped>

</style>