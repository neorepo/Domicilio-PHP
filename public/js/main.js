'use strict';

const provinciaEl = document.querySelector('#provincia');
const localidadEl = document.querySelector('#localidad');

document.addEventListener('DOMContentLoaded', () => {
    initDatepicker();
    initOnchangeProvincia();
});

function initOnchangeProvincia() {
    if (!provinciaEl && !localidadEl) {
        return;
    }

    provinciaEl.onchange = function () {
        if (this.value === 'C') {
            reset();
            let newOption = document.createElement("option");
            newOption.value = 5001;
            newOption.text = "CIUDAD AUTONOMA DE BUENOS AIRES";
            try {
                localidadEl.add(newOption);
            } catch (e) {
                localidadEl.appendChild(newOption);
            }
            document.querySelector("#wrapper-localidad").style.display = '';
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
    let rows = JSON.parse(response);

    reset();

    rows.forEach(row => {
        newOption = document.createElement("option");
        newOption.value = row.id_localidad;
        newOption.text = `${row.nombre} (${row.codigo_postal})`;
        // add the new option 
        try {
            // this will fail in DOM browsers but is needed for IE
            $fragment.add(newOption);
        } catch (e) {
            $fragment.appendChild(newOption);
        }
    });

    localidadEl.appendChild($fragment);
    document.querySelector("#wrapper-localidad").style.display = '';
}

function reset() {
    localidadEl.options.length = 0;
    localidadEl.options[0] = new Option("Seleccione una localidad");
    localidadEl.options[0].value = 0;

    document.querySelector("#wrapper-localidad").style.display = 'none';
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
            yearRange: "1905:c"// or 1905:yy or 1905:new Date() or 1905:new Date().getFullYear()
        });
}