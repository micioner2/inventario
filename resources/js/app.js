
window.Vue = require('vue');
import Vuex from 'vuex';                                                                                                                 
import StoreData from './store';
Vue.use(Vuex);

require('./bootstrap');

const store = new Vuex.Store(StoreData);

Vue.component('inicio', require('./components/Inicio.vue').default);
Vue.component('empresa', require('./components/Empresa.vue').default);
Vue.component('cliente', require('./components/Cliente.vue').default);
Vue.component('proveedor', require('./components/Proveedor.vue').default);
Vue.component('ingreso', require('./components/Ingreso.vue').default);
Vue.component('almacen', require('./components/Almacen.vue').default);
Vue.component('venta', require('./components/Venta.vue').default);
Vue.component('admingreso', require('./components/AdmIngreso.vue').default);
Vue.component('admventa', require('./components/AdmVenta.vue').default);




const app = new Vue({
    el: '#app',
    store,
    data :{
        menu: 3,
        // enlace: 'http://www.panaderiadorita.com'
        enlace: 'http://192.168.1.34:8080/inventario/public'
        // enlace: 'http://localhost:8080/inventario/public/'
    } 
});
