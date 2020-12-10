'use strict';

const selectProvincia = document.querySelector('select#provincia');
const selectLocalidad = document.querySelector('select#localidad');

document.addEventListener('DOMContentLoaded', () => {
    initDatepicker();
    initChangeProvince();
});

function initChangeProvince() {
    if (!selectProvincia) return;
    selectProvincia.onchange = function (e) {
        // Si no existe el elemento select localidad, detenemos el proceso
        if (!selectLocalidad) return;
        if (this.value === 'C') {
            reset();
            let newOption = document.createElement("option");
            newOption.value = 5001;
            newOption.text = "CIUDAD AUTONOMA DE BUENOS AIRES";
            try {
                selectLocalidad.add(newOption);
            } catch (e) {
                selectLocalidad.appendChild(newOption);
            }
            return;
        }
        if (!validCharacter(this.value)) {
            reset();
            return;
        }
        let data = "provincia=" + encodeURIComponent(this.value);
        sendHttpRequest('POST', 'server_processing.php', data, loadLocalities);
    }
}

function loadLocalities(response) {
    let newOption;
    const $fragment = document.createDocumentFragment();
    let data = JSON.parse(response);
    reset();
    data.forEach(item => {
        newOption = document.createElement("option");
        newOption.value = item.id_localidad;
        newOption.text = `${item.nombre} (${item.codigo_postal})`;
        // add the new option 
        try {
            // this will fail in DOM browsers but is needed for IE
            $fragment.add(newOption);
        } catch (e) {
            $fragment.appendChild(newOption);
        }
    });
    selectLocalidad.appendChild($fragment);
}

function reset() {
    selectLocalidad.options.length = 0;
    selectLocalidad.options[0] = new Option("- Seleccionar -");
    selectLocalidad.options[0].value = 0;
}

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
            yearRange: '1905:' + new Date().getFullYear() - 18
        });
}