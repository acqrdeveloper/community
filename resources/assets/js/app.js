/**
 * Created by aquispe on 25/10/2017.
 */

import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from './components/Home.vue';
// PERSONA
import PersonaList from './components/PersonaList.vue';
import PersonaCreate from './components/PersonaCreateUpdate.vue';
import PersonaEdit from './components/PersonaCreateUpdate.vue';
import PersonaDetail from './components/PersonaDetail.vue';
// TABLAS MANTENIMIENTO
import TablasList from './components/TablasList.vue';
// COMPROBANTE
import ComprobanteCreateUpdate from './components/ComprobanteCreateUpdate.vue'
// EMPRESA
import EmpresaCreate from './components/EmpresaCreateUpdate.vue';

Vue.use(VueRouter);

const ROUTER = new VueRouter({
    mode: 'history',
    routes: [
        // HOME
        {
            path: '/home',
            component: Home,
            name: 'home'
        },
        // PERSONA
        {
            path: '/personas',
            component: PersonaList,
            name: 'personas'
        },
        {
            path: '/persona-create',
            component: PersonaCreate,
            name: 'persona-create'
        },
        {
            path: '/persona-edit/:id',
            component: PersonaEdit,
            name: 'persona-edit'
        },
        {
            path: '/persona-show/:id',
            component: PersonaDetail,
            name: 'persona-show'
        },
        // EMPRESA
        {
            path: '/empresa-create',
            component: EmpresaCreate,
            name: 'empresa-create'
        },
        // MANTENIMIENTO
        {
            path: '/tablas',
            component: TablasList,
            name: 'tablas'
        },
        // COMPROBANTE
        {
            path:'/comprobante-create',
            component:ComprobanteCreateUpdate,
            name:'comprobante-create'
        }
    ]
});

new Vue({
    router: ROUTER,
}).$mount('#wrapper');