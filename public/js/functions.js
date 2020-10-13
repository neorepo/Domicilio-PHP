// Validamos que contenga un identificador válido
function validId(id, min, max) {
    if (get_int(id)) {
        id = parseInt(id);
        if (id >= min && id <= max) {
            return true;
        }
    }
    return false;
}

// Validamos el caracter que forma parte del código 33166-2
function validCharacter(c) {
    let re = /^[BKHUXWEPYLFMNQRAJDZSGVT]{1}$/; //No incluidas => C,I,Ñ,O
    return re.test(c);
    /*let arr = ['B', 'K', 'H', 'U', 'X', 'W', 'E', 'P', 'Y', 'L', 'F', 'M', 'N', 'Q', 'R', 'A', 'J', 'D', 'Z', 'S', 'G', 'V', 'T'];
    return arr.includes(val);*/
}

function get_int(n) {
    if (n != null) {
        // Si es un caracter numérico entero
        if (/^[+-]?\d+$/.test(n)) {
            return true;
        }
    }
    return false;
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
    let customElement = document.createElement(element);
    let text = document.createTextNode(textNode);
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