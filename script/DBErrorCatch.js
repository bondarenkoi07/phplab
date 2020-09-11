'use strict';
function extractGetAll() {
    var vars = window.location.search.match(new RegExp('[^&?]+', 'gm'));
    var result = {};
    for (var i=0; i < vars.length; i++) {
        var r = vars[i].split('=');
        result[r[0]] =r[1];
    }
    return result;
}
function extractGet(name) {
    var result = window.location.search.match(new RegExp(name + '=([^&=]+)'));
    return result ? decodeURIComponent( result[1].replace(/\+/g, " ") ) : false;
}



