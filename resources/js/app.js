/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

import Routes from "./routes";
import VueRouter from "vue-router";
import "@fortawesome/fontawesome-free/css/all.css";
import "@fortawesome/fontawesome-free/js/all.js";
import { Form, HasError, AlertError } from "vform";
import wysiwyg from "vue-wysiwyg";

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.use(VueRouter);
Vue.use(wysiwyg, {});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))Vue.prototype.$http = axios.create();

window.Inbox.basePath = "/" + window.Inbox.path;

let routerBasePath = window.Inbox.basePath + "/";

if (window.Inbox.path === "" || window.Inbox.path === "/") {
  routerBasePath = "/";
  window.Inbox.basePath = "";
}

const router = new VueRouter({
  routes: Routes,
  mode: "history",
  base: routerBasePath
});

Vue.component("pagination", require("laravel-vue-pagination"));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: "#app",
  router
});
