export default {
    props: {
        value: {
            required: true
        },
        sizeClass: {
            type: String,
            default: 'col-sm-12'
        },
        editing: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            inputValue: null
        }
    },
    mounted() {
        this.inputValue = this.value
    },
    computed: {
        disabled() {
            return this.$store.getters['transactions/isFormLoading']
        }
    },
    watch: {
        inputValue(newValue, oldValue) {
            if (newValue !== oldValue)
                this.$emit('input', newValue)
        },
        value(newValue) {
            this.inputValue = newValue
        }
    }
}