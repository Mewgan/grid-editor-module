import Vue from 'vue'
import Vuex from 'vuex'

import grid_editor from './grid-editor'

Vue.use(Vuex);

export default new Vuex.Store({
    modules:{
        grid_editor
    }
})
