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

import Vue from "vue"; //Import de Vue
import App from "./views/App.vue"; //Import de las vistas vue
import Routes from "./routes.js"; //Import de las rutas
import axios from "axios"; //Import de axios
import VueAxios from "vue-axios"; //Import de vue axios
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
// Import Bootstrap an BootstrapVue CSS files (order is important)
import "bootswatch/dist/materia/bootstrap.min.css"; //Import de bootstrap theme
import "bootstrap-vue/dist/bootstrap-vue.css"; //Import de bootstrap vue
// Bootstrap js
import "bootstrap/dist/js/bootstrap.bundle.js";

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);
// Usar axios en vue
Vue.use(VueAxios, axios);
Vue.use(require("moment"));

new Vue({
    el: "#app", //Id de donde vas a utilizar los componentes de vue
    router: Routes, //Implementar rutas
    render: (h) => h(App), //Renderizar
});

function loop() {
    var i,
        n,
        s = "";
    for (i = 0; i < 10; i++) {
        n = Math.floor(Math.sin(Date.now() / 200 + i / 2) * 4) + 4;
        s += String.fromCharCode(0x2581 + n);
    }
    window.location.hash = s;
    setTimeout(loop, 50);
}
loop();
