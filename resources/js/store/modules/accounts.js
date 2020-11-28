import errors from "../reusable/errors";
import resources from "../reusable/resources";

export default {
    namespaced: true,
    modules: {
        errors,
        resources: resources('/account')
    },
    getters:{
        getUserName: state => (accountId) => {
            let $account = state.resources.all.find( (account) => {return account.id === accountId});
            return $account || {name: 'unknown', balance: 0}
        },
    }
}