require('./bootstrap');

window.Vue = require('vue').default;

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('product-component', require('./components/ProductComponent.vue').default);
// Vue.component('create-component', require('./components/CreateComponent.vue').default);


const app = new Vue({
    el: '#app',
});
