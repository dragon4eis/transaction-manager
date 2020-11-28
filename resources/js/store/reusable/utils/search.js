export default function (searchFields){
    return {
        state(){
            return {
                searchString: "",
                searchFields: searchFields
            }
        },
        mutations:{
            SET_SEARCH(state, new_search) {
                state.searchString =  new_search;
            },
            RESET_SEARCH(state){
                state.searchString = "";
            }
        },
        getters:{
            searchInObject: (state) => object => {
                let pureString = String(state.searchString).toLowerCase().trim();

                let result = state.searchFields.find(field => {
                   return String(object[field]).toLowerCase().includes(pureString)
                })
                return typeof result !== "undefined";
            }
        }
    }
}