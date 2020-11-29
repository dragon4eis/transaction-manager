const files = require.context('./modules', true, /\.js$/i)

export const modules = files.keys().map(file => files(file).default),
    home = makeRedirect('transaction-index');


export function makeRedirect(name) {
    return function (route) {
        return {
            name,
            // query: {
            //     page: route.query.page || 1
            // }
        }
    }
}

export function makeNestedRouterView(name, as = name) {
    const component = {
        name,
        render(h) {
            return h('router-view', {
                attrs: {name}
            })
        }
    };
    return as
        ? {[as]: component}
        : component
}