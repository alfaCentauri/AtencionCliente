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
import $ from 'jquery';
import './jquery.dataTables.min.js';

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

/** Source dataSets */
var dataSets = [];
var dataSetsCola2 = [];
/** DataTables config */
var table = $('#vueTable').DataTable( {
    data: dataSets,
    columns: [
        { title: "#" },
        { title: "idTicket" },
        { title: "Nombre" },
    ],
    "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "No hay registros disponibles",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrado de _MAX_ total registros)",
        "paginate": {
            "first": "Primera página",
            "last": "Ultima página",
            "next": "Página siguiente",
            "previous": "Página anterior"
        },
        "search": "Buscar: ",
    },
    "paging":   true,
    "ordering": false,
    "info":     false,
} );
var counterRows = 0;

/** Tabla con Vue **/
var vue2 = new Vue({
    el: '#vueTable1',
    data: {
        tickets: [],
    },
    delimiters: ['${','}$'],
    methods: {
        getCola(numeroCola) {
            $.ajax({
                url: "/api/"+numeroCola,
                data: null,     //debug
                dataType: 'text',
                cache: false,
                async: false,
                contentType: false,
                processData: false,
                mimeType: 'multipart/form_data',
                type: "POST",
                success: function (data) {
                    if (typeof (data) != 'undefined') {
                        var result = JSON.parse(data);
                        var colaAtencion = result['colaAtencion'];
                        var maximo = colaAtencion.length;
                        for (var i = 0; i < maximo; i++) {
                            var node = {
                                "id": (i+1),
                                "idTicket": colaAtencion[i]["idTicket"],
                                "Nombre": colaAtencion[i]["nombre"],
                            };
                            dataSets.push(node);
                            //Update table
                            table.row.add([
                                node['id'],
                                node['idTicket'],
                                node['Nombre'],
                            ]).draw(false);
                            counterRows++;
                        }
                    }
                },
                error: function () {
                    alert("Error on service!");
                    if (typeof (data) != 'undefined') {
                        result = JSON.parse(data);
                        console.log(result['message'] + "Status: " + result['status']);
                    }
                },
                complete: function () {
                    console.log("Completado la cola #1.");
                }
            });
        },
    },   
    created: function () {
        this.getCola(1);
        console.log('La data de la cola #1 es: ' + this.data);
        console.log("\nLa tabla #1 es: "+dataSets.toString());
    },
    beforeUpdate:function () {
        console.log('Antes de actualizar la data. ' );
        this.getCola(1);
        console.log("\nLa tabla #1 es: "+dataSets.toString());
    },
});

/** DataTables config */
var table2 = $('#vueTable2').DataTable( {
    data: dataSetsCola2,
    columns: [
        { title: "#" },
        { title: "idTicket" },
        { title: "Nombre" },
    ],
    "language": {
        "lengthMenu": "Mostrar _MENU_ registros por página",
        "zeroRecords": "No hay registros disponibles",
        "info": "Mostrando página _PAGE_ de _PAGES_",
        "infoEmpty": "No hay registros disponibles",
        "infoFiltered": "(filtrado de _MAX_ total registros)",
        "paginate": {
            "first": "Primera página",
            "last": "Ultima página",
            "next": "Página siguiente",
            "previous": "Página anterior"
        },
        "search": "Buscar: ",
    },
    "paging":   true,
    "ordering": false,
    "info":     false,
} );
var counterRows2 = 0;

/** Tabla de cola 2 con Vue **/
var vue3 = new Vue({
    el: '#vueTable2',
    data: {
        tickets: [],
    },
    delimiters: ['${','}$'],
    methods: {
        getCola() {
            $.ajax({
                url: "/api/2",
                data: null,     //debug
                dataType: 'text',
                cache: false,
                async: false,
                contentType: false,
                processData: false,
                mimeType: 'multipart/form_data',
                type: "POST",
                success: function (data) {
                    if (typeof (data) != 'undefined') {
                        var result = JSON.parse(data);
                        var colaAtencion = result['colaAtencion'];
                        var maximo = colaAtencion.length;
                        for (var i = 0; i < maximo; i++) {
                            var node = {
                                "id": (i+1),
                                "idTicket": colaAtencion[i]["idTicket"],
                                "Nombre": colaAtencion[i]["nombre"],
                            };
                            dataSetsCola2.push(node);
                            //Update table
                            table2.row.add([
                                node['id'],
                                node['idTicket'],
                                node['Nombre'],
                            ]).draw(false);
                            counterRows2++;
                        }
                    }
                },
                error: function () {
                    alert("Error on service!");
                    if (typeof (data) != 'undefined') {
                        result = JSON.parse(data);
                        console.log(result['message'] + "Status: " + result['status']);
                    }
                },
                complete: function () {
                    console.log("Completada la cola 2.");
                }
            });
        },
    },
    created: function () {
        this.getCola();
        console.log('La data de la cola 2 es: ' + this.data);
        console.log("\nLa tabla #2 es: "+dataSetsCola2.toString());
    },
    beforeUpdate:function () {
        console.log('Antes de actualizar la data. ' );
        this.getCola();
        console.log("\nLa tabla #2 es: "+dataSetsCola2.toString());
    },
});