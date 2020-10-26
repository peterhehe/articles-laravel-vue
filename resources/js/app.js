/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
import TableComponent from './components/TableComponent.vue';
import FormComponent from './components/FormComponent.vue';
import PaginationComponent from './components/PaginationComponent.vue';
import MainComponent from './components/MainComponent.vue';
import ViewComponent from './components/ViewComponent.vue';
import NewFormComponent from './components/NewFormComponent.vue';
import ArticleTagComponent from './components/ArticleTagComponent.vue';

Vue.component('table-component', TableComponent);
Vue.component('form-component', FormComponent);
Vue.component('pagination-component', PaginationComponent);
Vue.component('main-component', MainComponent);
Vue.component('view-component', ViewComponent);
Vue.component('new-form-component', NewFormComponent);
Vue.component('article-tag-component', ArticleTagComponent);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
// import Form from './components/Form.js';

// window.Form = Form;

