import {ucFirst} from "../../../helpers";

export default function (sortingFields){
    return {
        state(){
            return {
                activeSort: 0,
                sortingFields: sortingFields
            }
        },
        mutations:{
            SET_ACTIVE_SORT(state, sort){
                state.activeSort = sort;
            },
            RESET_SORT(state){
                state.activeSort = 0;
            }
        },
        getters:{
            getSortTypes: (state) => {
                let $availableSorts = [];
                if(state.sortingFields.length){
                    state.sortingFields.forEach(field => {
                        $availableSorts.push({
                            label: `${ucFirst(field)} (asc)`,
                            field,
                            order: 1
                        });
                        $availableSorts.push({
                            label: `${ucFirst(field)} (desc)`,
                            field,
                            order: -1
                        });
                    })
                }
                return $availableSorts;
            },
            sortObjects: (state, getters) => (objectA, objectB) =>{
                let sort = getters['getSortTypes'][ state.activeSort] || null;
                if(sort){
                    return sort.order * String(objectA[sort.field]).localeCompare(String(objectB[sort.field]))
                } else {
                    return true;
                }
            }
        }
    }
}