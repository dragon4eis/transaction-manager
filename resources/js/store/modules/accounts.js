import resources from "../reusable/resources";
import axios from "axios";

export default {
    namespaced: true,
    modules: {
        resources: resources('/account')
    },
    state: {
        formLoading: false,
    },
    mutations:{
        SET_ELEMENT_LOADING(state, loading) {
            state.formLoading = loading
        },
    },
    getters:{
        getUserName: state => (accountId) => {
            let $account = state.resources.all.find((account) => {
                return account.id === accountId
            });
            return $account || {name: 'unknown', balance: 0}
        },
    },
    actions:{
        updateResource({commit}, id) {
            commit('SET_ELEMENT_LOADING', true);
            return axios.get(`account/${id}`)
                .then(response => {
                    commit('UPDATE_EXISTING_RESOURCE', response.data.data);
                    return response;
                })
                .catch(error => {
                    throw error
                })
                .finally(() =>{
                    commit('SET_ELEMENT_LOADING', false);
                })
        },
    }
}