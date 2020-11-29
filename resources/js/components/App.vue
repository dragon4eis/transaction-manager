<template>
    <div>
        <router-view></router-view>
        <router-view name="modalView"></router-view>
    </div>

</template>

<script>
export default {
    name: "single-page-app",
    mounted(){
        this.$store.dispatch('transactions/all')
        this.$store.dispatch('accounts/all')
    }
}
</script>

<style scoped>

</style>
