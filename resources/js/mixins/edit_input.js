export default {
    props: {
        form: {
            required: true
        },
        field:{
            type:String,
            required: true
        },
    },
    data() {
        return {
            inputValue: null,
            edit: false
        }
    },
    computed: {
        isEditStarted() {
            return this.$store.state.transactions.editing
        },
        label(){
            return  this.form[this.field]
        },
    },
    methods: {
        cancelEdit() {
            this.$store.commit('transactions/SET_EDITING_STATE', false)
            this.edit = false;
        },
        enableEditing() {
            if (!this.isEditStarted) {
                this.$store.commit('transactions/SET_EDITING_STATE', true);
                this.inputValue = this.form[this.field];
                this.edit = true
            }
        },
        submit() {
            console.info(' .... submitting needs implementation')
        }
    }
}