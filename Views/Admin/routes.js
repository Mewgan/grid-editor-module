
export var routes = [
   
];


export var content_routes = {
    gridEditor:  (resolve) => { require(['./components/GridEditorModule.vue'],resolve)}
};


export default {
    routes,
    content_routes
}