const files = require.context('./modules', true, /\.js$/i);

export const modules = files.keys().reduce((modules, file) => {
    const id = file
        .split('/')
        .pop()
        .split('.')[0];
    modules[id] = files(file).default;
    return modules
}, {})
