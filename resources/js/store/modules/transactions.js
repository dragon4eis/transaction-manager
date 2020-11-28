import axios from 'axios';
import errors from "../reusable/errors";
import resources from "../reusable/resources";
import sort from "../reusable/utils/sort";
import search from "../reusable/utils/search";

export default {
    namespaced: true,
    modules: {
        errors,
        resources: resources('/transaction'),
        sort: sort( ['id', 'name']),
        search: search (['type_name', 'name', 'email', 'amount'])
    },
    state: {
        formLoading: false,
    },
    mutations: {
        SET_ELEMENT_LOADING(state, loading) {
            state.formLoading = loading
        },
    },
    getters: {
        findTransactions: (state, getters) => {
            return state.resources.all
                .filter(transaction => getters.searchInObject(transaction))
                .sort((a,b) => getters.sortObjects(a,b));
        }
    },
    actions: {
        submit({state, commit, dispatch}, form) {
            commit('SET_ELEMENT_LOADING', true);
            let requestType = (form.id) ? "put" : "post";
            let url = `/transaction/${(requestType === "post" ? '' : form.id)}`;
            return new Promise(((resolve, reject,) => {
                axios[requestType](url, form)
                    .then(response => {
                        commit('clearErrors');
                        // dispatch('all');
                        commit(requestType === "post" ? 'ADD_NEW_RESOURCE' : 'UPDATE_EXISTING_RESOURCE', response.data.resource);
                        resolve(response);
                    })
                    .catch(error => {
                        console.error(error);
                        if (error.response.status === 422) {
                            commit('addErrors', error.response.data.errors);
                        }
                        reject(error)
                    })
                    .finally(() => {
                        commit('SET_ELEMENT_LOADING', false);
                    })
            }))
        },
        deleteElement({commit, dispatch}, id) {
            commit('SET_ELEMENT_LOADING', true);
            return axios.delete(`/transaction/${id}`)
                .then(response => {
                    // dispatch('all');
                    commit('REMOVE_RESOURCE', id)
                    return response;
                })
                .catch(error => {
                    return error;
                }).finally(() => {
                    commit('SET_ELEMENT_LOADING', false);
                })
        },
    }
}
