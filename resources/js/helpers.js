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
