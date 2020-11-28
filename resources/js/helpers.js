/**
 *
 * @param {*} value
 * @return {number|*}
 */
export function toNumber(value) {
    const number = parseFloat(value);
    return isNaN(number)
        ? value
        : number
}

export function ucFirst(value){
    return value.charAt(0).toUpperCase() + value.slice(1)
}