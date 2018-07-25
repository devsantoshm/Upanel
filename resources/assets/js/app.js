
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('chart.js');

window.$ = window.JQuery = require('jquery');
window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('categoria-component', require('./components/CategoriaComponent'));
Vue.component('articulo-component', require('./components/ArticuloComponent'));
Vue.component('cliente-component', require('./components/ClienteComponent'));
Vue.component('proveedor-component', require('./components/ProveedorComponent'));
Vue.component('rol-component', require('./components/RolComponent'));
Vue.component('user-component', require('./components/UserComponent'));
Vue.component('ingreso-component', require('./components/IngresoComponent'));
Vue.component('venta-component', require('./components/VentaComponent'));
Vue.component('dash-component', require('./components/DashboardComponent'));
Vue.component('reportingresos-component', require('./components/ConsultaIngresoComponent'));
Vue.component('reportventas-component', require('./components/ConsultaVentasComponent'));
Vue.component('notificacion-component', require('./components/NotificacionComponent'));

const app = new Vue({
    el: '#app',
    data :{
        menu : 0,
        notifications: []
    },
    created() {
        let me = this;
        axios.post('notification/get').then(function(response) {
            //console.log(response.data);
            me.notifications = response.data;
        }).catch(function(error) {
            console.log(error);
        });

        let userId = $('meta[name="userId"]').attr('content');

        Echo.private('App.User.' + userId).notification((notification) => {
            me.notifications.unshift(notification);
        });

    }
});
