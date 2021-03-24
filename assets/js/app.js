/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import "../styles/app.css";

// start the Stimulus application
import "./bootstrap";

import Vue from "vue";

import { BootstrapVue, IconsPlugin } from "bootstrap-vue";

import axios from "axios";
import VueAxios from "vue-axios";

import App from "./views/App.vue";

import Routes from "./routes.js";

// Import Bootstrap an BootstrapVue CSS files (order is important)
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";

// Bootstrap js
import "bootstrap/dist/js/bootstrap.bundle.js";

// //jQuery
// import "jquery/dist/jquery.js";

// // require jQuery normally
// const $ = require('jquery');
// // create global $ and jQuery variables
// global.$ = global.jQuery = $;



// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

Vue.use(VueAxios, axios);

new Vue({
    el: "#app",
    router: Routes,
    render: (h) => h(App),
});