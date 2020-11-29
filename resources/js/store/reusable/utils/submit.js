import axios from "axios";

export default function (resourceAddress){
    return {
        state(){
            return {
                formLoading: false,
            }
        },
        mutations:{
            SET_ELEMENT_LOADING(state, loading) {
                state.formLoading = loading
            },
        },
        getters:{
            isFormLoading: state =>{
                return state.formLoading
            }
        },
        actions:{
            submitForm({state, commit, dispatch}, form) {
                commit('SET_ELEMENT_LOADING', true);
                let requestType = (form.id) ? "put" : "post";
                let url = `/${resourceAddress}${(requestType === "post" ? '' : `/${form.id}`)}`;
                return new Promise(((resolve, reject,) => {
                    axios[requestType](url, form)
                        .then(response => {
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
        }
    }
}