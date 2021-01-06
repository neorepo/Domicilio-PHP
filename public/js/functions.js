// Validamos que contenga un identificador válido
function isValidId(id, min, max) {
    if (!get_int(id)) return false;
    id = parseInt(id);
    return (id >= min && id <= max);
}

function get_int(n) {
    if (n == null) return false;
    // Si es un caracter numérico entero
    return (/^[+-]?\d+$/.test(n));
}

// Validamos el caracter que forma parte del código 33166-2
function validCharacter(c) {
    // Letras mayúsculas, no minúsculas
    const re = /^[ABCDEFGHJKLMNPQRSTUVWXYZ]{1}$/; // No incluidas => I,Ñ,O
    return re.test(c);
}

// https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/Using_XMLHttpRequest
function sendHttpRequest(method, url, data, callback) {
    const xhr = getXhr();
    xhr.onreadystatechange = processRequest;
    function getXhr() {
        if (window.XMLHttpRequest) {
            return new XMLHttpRequest();
        } else {
            return new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    function processRequest() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                if (callback) callback(xhr.responseText);
            }
        }
    }
    xhr.open(method, url + ((/\?/).test(url) ? "&" : "?") + (new Date()).getTime());
    if (data && !(data instanceof FormData)) xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send(data);
}

function createCustomElement(element, textNode, attributes, children = []) {
    const customElement = document.createElement(element);
    const text = document.createTextNode(textNode);
    customElement.appendChild(text);

    if (children !== "undefined") {
        children.forEach(el => {
            if (el.nodeType) {
                if (el.nodeType === 1 || el.nodeType === 11) customElement.appendChild(el);
            } else {
                customElement.innerHTML += el;
            }
        });
    }

    addAttribute(customElement, attributes);
    return customElement;
}

function addAttribute(element, attributes) {
    for (let attr in attributes) {
        // console.log(attributes.hasOwnProperty(attr));
        element.setAttribute(attr, attributes[attr]);
    }
}