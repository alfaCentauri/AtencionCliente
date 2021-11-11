/***/
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
import $ from 'jquery';

/**Definition of the components */
Vue.component('vueTable', {
    props: ['dataSets'],
    template: ''
});

/** Source dataSets */
var dataSets = [];
/** DataTables config */
var table = $('#vueTable').DataTable( {
    data: dataSets,
    columns: [
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
    "paging":   false,
    "ordering": false,
    "info":     false,
} );
var counterRows = 0;

/** Tabla con Vue **/
var vue2 = new Vue({
    el: '#vue-table',
    data: {
        cola: [],
    },
    delimiters: ['${','}$'],
    methods: {
        getCola(numeroCola) {
            $ajax({
                url: "{{ path('api_colas', {'numeroCola': "+numeroCola+"}) }}",
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
                        result = JSON.parse(data);
                        var maximo = result.length;
                        for (var i = 0; i < maximo; i++) {
                            var node = {
                                "idTicket": result[i]["idTicket"],
                                "Nombre": result[i]["name"],
                            };
                            dataSets.push(node);
                            //Update table
                            table.row.add([
                                node['idTicket'],
                                node['Nombre'],
                            ]).draw(false);
                            counterRows++;
                            //Clean input
                        }
                    }
                },
                error: function () {    //debug
                    alert("Error on service!");
                },
                complete: function () {
                    console.log("Completado...");
                }
            });
        },
    }
});
