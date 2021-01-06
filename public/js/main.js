'use strict';

const selectP = document.querySelector('select#provincia');
const selectL = document.querySelector('select#localidad');

document.addEventListener('DOMContentLoaded', () => {
    initDatepicker();
    initSelect2();
    initChangeProvincia();

    // Seteamos el estado inicial del select de localidades a deshabilitado
    if (selectL) selectL.disabled = true;
});

// https://github.com/jquery/jquery-ui/blob/master/ui/i18n/datepicker-es.js
function initDatepicker() {
    $('.datepicker')
        .attr('readonly', 'readonly')
        .datepicker({
            prevText: "Anterior",
            nextText: "Siguiente",
            currentText: "Hoy",
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
            monthNames: ["enero", "febrero", "marzo", "abril", "mayo", "junio",
                "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"],
            monthNamesShort: ["ene", "feb", "mar", "abr", "may", "jun",
                "jul", "ago", "sep", "oct", "nov", "dic"],
            dayNames: ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"],
            dayNamesShort: ["dom", "lun", "mar", "mié", "jue", "vie", "sáb"],
            dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
            isRTL: false,
            // minDate: new Date(1905, 1 - 1, 1),
            // maxDate: "dd/m/Y",
            showMonthAfterYear: false,
            /*showWeek: true,
            weekHeader: "Sm",*/
            //yearRange: "1905:c"// or 1905:yy or 1905:new Date() or 1905:new Date().getFullYear()
            yearRange: '1905:' + (new Date().getFullYear() - 18)
        });
}

// Inicialización Select2
function initSelect2() {
    $('#provincia').select2({
        theme: 'bootstrap4',
        language: {
            noResults: function () { return "No se encontraron resultados" }
        }
    });
    $('#localidad').select2({
        // placeholder: '- Seleccione una opción -',
        // allowClear: true,
        theme: 'bootstrap4',
        minimumInputLength: 3,
        language: {
            inputTooShort: function (e) {
                var n = e.minimum - e.input.length, r = "Por favor, introduzca " + n + " car"; return r += 1 == n ? "ácter" : "acteres";
            },
            noResults: function () { return "No se encontraron resultados"; }
        }
    });
}

function initChangeProvincia() {
    if (selectP) {
        selectP.onchange = function (e) { return handleChangeProvincia(this, e); }
    }
}

function handleChangeProvincia(objSelect, objEvent) {
    if (!selectL) return;
    selectL.disabled = true;
    // Si el select de localidades contiene opciones, las removemos.
    removeOptions(selectL);
    if (objSelect.selectedIndex > 0) {
        selectL.disabled = false;
        const value = objSelect.value;
        // Si no es un carácter válido
        if (!validCharacter(value)) return;
        // Si el carácter es de la CABA
        if (value === 'C') {
            createOptions(selectL, [{ id_localidad: "5001", nombre: "CIUDAD AUTONOMA DE BUENOS AIRES", codigo_postal: "" }]);
        } else {
            const formData = "provincia=" + encodeURIComponent(value);
            sendHttpRequest('POST', 'server_processing.php', formData, cargarLocalidades);
        }
    }
}

function cargarLocalidades(response) {
    const data = JSON.parse(response);
    if (!data.success) return;
    createOptions(selectL, data.localidades);
}

function createOptions(selectObj, data) {
    let newOpt;
    const fragment = document.createDocumentFragment();
    data.forEach(obj => {
        newOpt = document.createElement("option");
        newOpt.value = obj.id_localidad;
        newOpt.text = `${obj.nombre} (${obj.codigo_postal})`;
        // add the new option 
        try {
            // this will fail in DOM browsers but is needed for IE
            fragment.add(newOpt);
        } catch (e) {
            fragment.appendChild(newOpt);
        }
    });
    selectObj.appendChild(fragment);
}

function removeOptions(objSelect) {
    let len = objSelect.options.length;
    while (len-- > 1) objSelect.remove(1);
}