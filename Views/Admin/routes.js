
export var routes = [
    {
        path: 'module/content/post',
        name: 'module:content:grid_editor',
        component:  resolve => require(['./components/GridEditorContent.vue'],resolve)
    }
];


export var content_routes = {
    gridEditor:  (resolve) => { require(['./components/GridEditorContent.vue'],resolve)}
};


export default {
    routes,
    content_routes
}