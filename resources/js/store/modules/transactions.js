import axios from 'axios';
import errors from "../reusable/errors";
import resources from "../reusable/resources";

export default {
    namespaced: true,
    modules: {
        errors,
        resources: resources('/transaction')
    },
    state: {
        formLoading: false,
        searchString: "",
    },
    mutations: {
        SET_ELEMENT_LOADING(state, loading) {
            state.formLoading = loading
        },
        SET_SEARCH(state, new_search) {
            state.searchString = new_search
        }
    },
    getters: {
        findTransactions: (state) => {

            let cleanString = String(state.searchString).toLowerCase().trim();

            return state.resources.all
                .filter(transaction => {
                    return transaction.type_name.includes(cleanString)
                        || transaction.name.toLowerCase().includes(cleanString)
                        || transaction.email.toLowerCase().includes(cleanString)
                        || String(transaction.amount).includes(cleanString)
                });
        }
    },
    actions: {
        submit({state, commit, dispatch}, form) {
            commit('setElementLoading', true);
            let requestType = (form.id) ? "put" : "post";
            let url = `/todoList/${(requestType === "post" ? '' : form.id)}`;
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
                        commit('setElementLoading', false);
                    })
            }))
        },
        deleteElement({dispatch}, id) {
            return axios.delete(`/todoList/${id}`)
                .then(response => {
                    dispatch('all');
                    return response;
                })
                .catch(error => {

                })
        },
        updateResource({commit}, id) {
            return axios.get(`todoList/${id}`)
                .then(response => {
                    commit('UPDATE_EXISTING_RESOURCE', response.data);
                    return response;
                })
                .catch(error => {
                    throw error
                })
        },
    }
}
