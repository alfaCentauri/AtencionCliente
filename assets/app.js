/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

/**Definition of the components */
Vue.component('id-ticket', {
    props: ['id'],
    template: '<div class="input-group">\n' +
        '           <div class="col-sm-12 offset-md-2 col-md-4 col-lg-3" >\n' +
        '               <label for="id" class="form-label">Id: </label>\n' +
        '           </div>\n' +
        '           <div class="col-sm-12 col-md-4 col-lg-3" >\n' +
        '               <input type="number" id="id" name="id" class="form-control" v-model="id" placeholder="0" />\n' +
        '           </div>\n' +
        '      </div>'
});

Vue.component('name-ticket', {
    props: ['nombre'],
    template: '<div class="input-group">\n' +
        '           <div class="col-sm-12 offset-md-2 col-md-4 col-lg-3" >\n' +
        '               <label for="nombre" class="form-label">Nombre: </label>\n' +
        '           </div>\n' +
        '           <div class="col-sm-12 col-md-4 col-lg-3" >\n' +
        '               <input type="text" id="nombre" name="nombre" class="form-control" v-bind:value="nombre" v-on:input="$emit(\'input\', $event.target.value)"\n' +
        '                   placeholder="Escriba un nombre"/>\n' +
        '           </div>\n' +
        '      </div>'
});

/**Instancia*/
var vue = new Vue({
    el: '#vue-app',
    data: {
        id: 0,
        nombre: "",
        message: "Nuevo ticket"
    },
    delimiters: ['${','}$'],
});
