<template>
    <div class="row">
        <div class="row col-12 mb-3">
            <div class="col-6">
                <input v-model="search" class="form-control" placeholder="Search" type="text">
            </div>
            <div class="col-6">
                <div class="btn-group float-right">
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Order
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-12 scrollable">
            <tr-transaction-table :transactions="filtered_transactions"></tr-transaction-table>
        </div>
    </div>
</template>

<script>
import TrTransactionTable from "./tables/TransactionTable";

export default {
    name: "tr-transaction-page",
    components: {
        TrTransactionTable
    },
    data() {
        return {
        }
    },
    computed: {
        search:{
            get(){
                return this.$store.state.transactions.searchString
            },
            set(value){
                this.$store.commit('transactions/SET_SEARCH', value)
            }
        },
        transactions() {
            return this.$store.state.transactions.resources.all
        },
        filtered_transactions() {
            return this.$store.getters['transactions/findTransactions']
        }
    }
}
</script>

<style scoped>
.scrollable {
    overflow-y: auto;
    max-height: calc(100vh - 400px);
}
</style>