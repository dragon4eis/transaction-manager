import errors from "../reusable/errors";
import submit from "../reusable/utils/submit";

export default {
    namespaced: true,
    modules:{
        errors,
        submit: submit('user')
    },
}