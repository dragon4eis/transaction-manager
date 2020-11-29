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
                    state.sortingFields.forEach(element => {
                        $availableSorts.push({
                            label: `${ucFirst(element.field)} (asc)`,
                            field: element.field,
                            type:   element.type,
                            order: 1
                        });
                        $availableSorts.push({
                            label: `${ucFirst(element.field)} (desc)`,
                            field: element.field,
                            type:   element.type,
                            order: -1
                        });
                    })
                }
                return $availableSorts;
            },
            parseOrderValue: (state) => (value1, value2, type) =>{
                switch (type){
                    case 'int':
                    case 'float':
                       return value1 - value2;
                    case 'string':
                        return  value1.localeCompare(value2);
                    default:
                        return false
                }
            },
            sortObjects: (state, getters) => (objectA, objectB) =>{
                let sort = getters['getSortTypes'][ state.activeSort] || null;
                if(sort){
                    return sort.order * getters['parseOrderValue'](objectA[sort.field], objectB[sort.field], sort.type)
                } else {
                    return true;
                }
            }
        }
    }
}