<template>
    <div class="row">
        <div class="row col-12 mb-3">
            <div class="col-3 ">
                <input v-model="search" :disabled="disableNav"
                       class="form-control"
                       placeholder="Search" type="text">
            </div>
            <div class="col-6 offset-3">
                <div class="btn-group float-right">
                    <button :disabled="disableNav" aria-expanded="false"
                            aria-haspopup="true"
                            class="btn btn-danger dropdown-toggle" data-toggle="dropdown" type="button">Order
                    </button>
                    <div class="dropdown-menu">
                        <span v-for="(sort, index) in sortOptions" :key="index"
                              :class="{active: active_sort === index}"
                              class="dropdown-item"
                              @click="setSorting(index)" v-text="sort.label"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row col-12 scrollable  mb-3">
            <tr-transaction-table :transactions="filtered_transactions"></tr-transaction-table>
        </div>
        <div class="row col-12">
            <div class="col-6">
                <button :disabled="disableNav" class="btn btn-primary"
                        @click="openSave"
                        type="button">
                    <i class="fas fa-pen"></i>
                    <span>Add new transaction</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import TrTransactionTable from "./tables/TransactionTable";
import {mapGetters} from "vuex";

export default {
    name: "tr-transaction-page",
    components: {
        TrTransactionTable
    },
    data() {
        return {}
    },
    methods: {
        setSorting(value) {
            this.$store.commit('transactions/SET_ACTIVE_SORT', value)
        },
        openSave(){
            this.$router.push({name: 'transaction-create'})
        }
    },
    computed: {
        ...mapGetters({
            filtered_transactions: 'transactions/findTransactions',
            sortOptions: 'transactions/getSortTypes',
            disableNav: 'transactions/isFormLoading',

        }),
        active_sort() {
            return this.$store.state.transactions.sort.activeSort
        },
        search: {
            get() {
                return this.$store.state.transactions.search.searchString
            },
            set(value) {
                this.$store.commit('transactions/SET_SEARCH', value)
            }
        },
    }
}
</script>

<style scoped>
.scrollable {
    overflow-y: auto;
    max-height: calc(100vh - 400px);
}
</style>